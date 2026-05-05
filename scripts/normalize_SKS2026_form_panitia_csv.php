<?php
/**
 * Normalize & deduplicate Google Form responses for SKS 2026 Panitia data.
 *
 * Input:  public/data-form-panitia-SKS-2026.csv
 * Output: public/data-form-panitia-SKS-2026-normalized.csv
 *         scripts/review_flags.txt
 *
 * Run from project root:
 *   php scripts/normalize_panitia_csv.php
 */

define('PROJECT_ROOT', dirname(__DIR__));

$inputCsv  = PROJECT_ROOT . '/public/data-form-panitia-SKS-2026.csv';
$outputCsv = PROJECT_ROOT . '/public/data-form-panitia-SKS-2026-normalized.csv';
$flagsFile = __DIR__ . '/review_flags.txt';

// ─── Expected column order (after your Google Sheets reorder) ────────────────
// 0  Timestamp
// 1  Divisi Panitia
// 2  Nama Lengkap
// 3  Nama Panggilan
// 4  Ukuran Kaos
// 5  Tanggal Lahir
// 6  Nomor HP +62
// 7  Alamat email
// 8  Alamat tinggal saat ini
// 9  Wilayah
// ─────────────────────────────────────────────────────────────────────────────

if (!file_exists($inputCsv)) {
    die("❌ Input CSV not found: $inputCsv\n");
}

// ─── Reference data (from seeders) ──────────────────────────────────────────

$knownWilayahs = [
    'St. Agustinus',
    'St. Anna',
    'St. Fransiskus Asisi',
    'St. Joachim',
    'St. Maria',
    'St. Paulus',
    'St. Petrus',
    'St. Thomas More',
    'St. Timotius',
    'St. Yohanes Rasul',
    'St. Yoseph',
];

// Form value → DB Division.name
$divisionMap = [
    'Sie Pendamping'              => 'Pendamping',
    'Sie Band & Singer'           => 'Band & Singer',
    'Sie Design'                  => 'Design',
    'Sie Choir'                   => 'Choir',
    'Sie Penjaga Pos'             => 'Penjaga Pos',
    'Sie Konsumsi'                => 'Konsumsi',
    'Sie Acara'                   => 'Acara',
    'Sie Kesehatan'               => 'Kesehatan',
    'Sie Perlengkapan'            => 'Perlengkapan',
    'Sie Keamanan & Kebersihan'   => 'Keamanan & Kebersihan',
    'Sie Publikasi & Dokumentasi' => 'Publikasi & Dokumentasi',
    'Sie Multi Media'             => 'Multimedia',
    'Sie Pendaftaran'             => 'Pendaftaran',
    'Sie MC'                      => 'MC',
    'Sie Liturgi & Doa'           => 'Liturgi & Doa',
    'Sie Materi'                  => 'Materi',
    'Sie Dana'                    => 'Dana',
    'Sie IT'                      => 'IT',
];

// CSV size value (uppercase) → TshirtSize.code in DB (adult category)
$sizeMap = [
    'S'    => 'S-Dewasa',
    'M'    => 'M-Dewasa',
    'L'    => 'L-Dewasa',
    'XL'   => 'XL-Dewasa',
    'XXL'  => '2XL-Dewasa',
    '2XL'  => '2XL-Dewasa',
    'XXXL' => '3XL-Dewasa',
    '3XL'  => '3XL-Dewasa',
    '4XL'  => '4XL-Dewasa',
    '5XL'  => '5XL-Dewasa',
];

// ─── Helper functions ────────────────────────────────────────────────────────

function normalizePhone(string $raw): string
{
    // Strip spaces, dashes, dots, parens
    $p = preg_replace('/[\s\-\(\)\.\+]+/', '', trim($raw));
    $p = preg_replace('/^62/', '0', $p);   // 628xxx → 08xxx
    if (str_starts_with($p, '8')) {
        $p = '0' . $p;                      // 8xxx → 08xxx
    }
    return $p;
}

function normalizeDate(string $raw): string
{
    $raw = trim($raw);
    if (empty($raw)) {
        return '';
    }
    // M/D/YYYY  or  MM/DD/YYYY  (Google Sheets default export)
    if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})$#', $raw, $m)) {
        return sprintf('%04d-%02d-%02d', $m[3], $m[1], $m[2]);
    }
    // Already YYYY-MM-DD
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
        return $raw;
    }
    return $raw; // unknown — will be flagged
}

function matchWilayah(string $raw, array $known): array
{
    $raw = trim($raw);
    if ($raw === '') {
        return ['', 'wilayah kosong'];
    }
    // Exact match (case-insensitive)
    foreach ($known as $w) {
        if (strcasecmp($raw, $w) === 0) {
            return [$w, ''];
        }
    }
    // Luar paroki variants
    if (stripos($raw, 'luar') !== false) {
        return ['LUAR_PAROKI', ''];
    }
    // Fuzzy: known name is contained in raw value
    foreach ($known as $w) {
        if (stripos($raw, $w) !== false) {
            return [$w, "wilayah fuzzy-matched '$raw' → '$w'"];
        }
    }
    return ['', "wilayah tidak dikenali: '$raw'"];
}

// ─── Read CSV ────────────────────────────────────────────────────────────────

$handle  = fopen($inputCsv, 'r');
$headers = fgetcsv($handle); // skip header row

$rows   = [];
$lineNo = 1; // header was line 1

while (($cols = fgetcsv($handle)) !== false) {
    $lineNo++;
    // Allow rows with fewer columns (trailing empty cells may be omitted)
    while (count($cols) < 10) {
        $cols[] = '';
    }

    $email = strtolower(trim($cols[7]));
    if (empty($email)) {
        continue; // skip rows with no email
    }

    $rows[] = [
        'line'      => $lineNo,
        'timestamp' => trim($cols[0]),
        'division'  => trim($cols[1]),
        'full_name' => trim($cols[2]),
        'nick_name' => trim($cols[3]),
        'tshirt'    => strtoupper(trim($cols[4])),
        'birth_date'=> trim($cols[5]),
        'phone'     => trim($cols[6]),
        'email'     => $email,
        'address'   => trim($cols[8]),
        'wilayah'   => trim($cols[9]),
    ];
}
fclose($handle);

echo "📥 Total baris dibaca: " . count($rows) . "\n";

// ─── Group by email & merge ──────────────────────────────────────────────────

$grouped = [];
foreach ($rows as $row) {
    $grouped[$row['email']][] = $row;
}

$normalized = [];
$allFlags   = [];

foreach ($grouped as $email => $records) {
    // Sort ascending by timestamp so latest is last
    usort($records, fn($a, $b) => strtotime($a['timestamp']) <=> strtotime($b['timestamp']));

    $latest   = end($records);
    $lineNums = implode(', ', array_column($records, 'line'));
    $rowFlags = [];

    // ── full_name: take the longest non-empty value ──────────────────────────
    $names = array_filter(array_map(fn($r) => $r['full_name'], $records), fn($n) => $n !== '');
    usort($names, fn($a, $b) => mb_strlen($b) <=> mb_strlen($a));
    $fullName   = $names[0] ?? '';
    $uniqueNames = array_unique($names);
    if (count($uniqueNames) > 1) {
        $rowFlags[] = 'nama conflict: [' . implode(' | ', $uniqueNames) . '] → diambil: "' . $fullName . '"';
    }

    // ── nick_name: latest non-empty ──────────────────────────────────────────
    $nickName = '';
    foreach (array_reverse($records) as $r) {
        if ($r['nick_name'] !== '') {
            $nickName = $r['nick_name'];
            break;
        }
    }

    // ── birth_date: first valid ───────────────────────────────────────────────
    $birthDate = '';
    foreach ($records as $r) {
        $d = normalizeDate($r['birth_date']);
        if ($d !== '') {
            $birthDate = $d;
            break;
        }
    }
    if ($birthDate !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthDate)) {
        $rowFlags[] = "format tanggal lahir tidak dikenali: '$birthDate'";
    }

    // ── phone: latest non-empty, then normalize ───────────────────────────────
    $phone = '';
    foreach (array_reverse($records) as $r) {
        if ($r['phone'] !== '') {
            $phone = normalizePhone($r['phone']);
            break;
        }
    }
    if ($phone !== '' && !preg_match('/^0[0-9]{7,13}$/', $phone)) {
        $rowFlags[] = "nomor HP suspect: '$phone'";
    }

    // ── address: latest non-empty ────────────────────────────────────────────
    $address = '';
    foreach (array_reverse($records) as $r) {
        if ($r['address'] !== '') {
            $address = $r['address'];
            break;
        }
    }

    // ── wilayah: latest non-empty, then normalize ─────────────────────────────
    $wilayahRaw = '';
    foreach (array_reverse($records) as $r) {
        if ($r['wilayah'] !== '') {
            $wilayahRaw = $r['wilayah'];
            break;
        }
    }
    [$wilayah, $wilayahFlag] = matchWilayah($wilayahRaw, $knownWilayahs);
    if ($wilayahFlag !== '') {
        $rowFlags[] = $wilayahFlag;
    }

    // ── division: latest record ───────────────────────────────────────────────
    $divisionRaw = $latest['division'];
    $division    = $divisionMap[$divisionRaw] ?? '';
    if ($division === '' && $divisionRaw !== '') {
        // Try stripping "Sie " prefix as a fallback
        $stripped = preg_replace('/^Sie\s+/iu', '', $divisionRaw);
        $division = $stripped;
        $rowFlags[] = "divisi tidak ada di map: '$divisionRaw' → fallback: '$division'";
    }

    // ── tshirt: latest record (already adult, map to DB code) ─────────────────
    $tshirtRaw  = strtoupper(trim($latest['tshirt']));
    $tshirtCode = $sizeMap[$tshirtRaw] ?? '';
    if ($tshirtCode === '' && $tshirtRaw !== '') {
        $rowFlags[] = "ukuran kaos tidak dikenali: '$tshirtRaw'";
    }

    // ── Collect flags ─────────────────────────────────────────────────────────
    $flagStr = implode('; ', $rowFlags);
    if ($flagStr !== '') {
        $allFlags[] = "Baris $lineNums  [$email]: $flagStr";
    }

    $normalized[] = [
        'email'         => $email,
        'full_name'     => $fullName,
        'nick_name'     => $nickName,
        'birth_date'    => $birthDate,
        'phone'         => $phone,
        'address'       => $address,
        'wilayah'       => $wilayah,
        'division'      => $division,
        'tshirt_size'   => $tshirtCode,
        'original_rows' => $lineNums,
        'flags'         => $flagStr,
    ];
}

// ─── Write normalized CSV ────────────────────────────────────────────────────

$out = fopen($outputCsv, 'w');
fputcsv($out, [
    'email', 'full_name', 'nick_name', 'birth_date', 'phone',
    'address', 'wilayah', 'division', 'tshirt_size', 'original_rows', 'flags',
]);
foreach ($normalized as $row) {
    fputcsv($out, array_values($row));
}
fclose($out);

// ─── Write review flags ──────────────────────────────────────────────────────

$flagsOut  = "SKS 2026 Panitia — Review Flags\n";
$flagsOut .= "Generated: " . date('Y-m-d H:i:s') . "\n";
$flagsOut .= str_repeat('─', 80) . "\n\n";

if (empty($allFlags)) {
    $flagsOut .= "✅ Tidak ada flag — semua data bersih!\n";
} else {
    foreach ($allFlags as $i => $flag) {
        $flagsOut .= ($i + 1) . ". $flag\n";
    }
}
file_put_contents($flagsFile, $flagsOut);

// ─── Summary ─────────────────────────────────────────────────────────────────

$total     = count($normalized);
$dupes     = count($rows) - $total;
$flagCount = count($allFlags);

echo "✅ Selesai!\n";
echo "   Input rows     : " . count($rows) . "\n";
echo "   Unique emails  : $total\n";
echo "   Duplikat merged: $dupes\n";
echo "   Rows flagged   : $flagCount\n";
echo "   Output CSV     : $outputCsv\n";
echo "   Flags file     : $flagsFile\n";
