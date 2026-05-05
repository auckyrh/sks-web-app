<?php

namespace Database\Seeders;

use App\Models\CommitteeAssignment;
use App\Models\Division;
use App\Models\EventPeriod;
use App\Models\TshirtSize;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SKS2026CommitteeSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = public_path('data-form-panitia-SKS-2026-normalized.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("Normalized CSV tidak ditemukan: $csvPath");
            $this->command->error("Jalankan dulu: php scripts/normalize_SKS2026_form_panitia_csv.php");
            return;
        }

        $period = EventPeriod::where('year', 2026)->firstOrFail();

        // Pre-load lookup maps to avoid N+1 queries
        $wilayahMap  = Wilayah::pluck('id', 'name')->toArray();
        $divisionMap = Division::pluck('id', 'name')->toArray();
        $sizeMap     = TshirtSize::where('event_period_id', $period->id)
            ->pluck('id', 'code')
            ->toArray();

        $handle = fopen($csvPath, 'r');
        fgetcsv($handle); // skip header

        $countCreated    = 0;
        $countSkipped    = 0;
        $countAssignment = 0;
        $warnings        = [];

        while (($cols = fgetcsv($handle)) !== false) {
            if (count($cols) < 9) {
                continue;
            }

            [
                $email, $fullName, $nickName, $birthDate, $phone,
                $address, $wilayah, $division, $tshirtSize,
            ] = $cols;

            $email = strtolower(trim($email));
            if (empty($email)) {
                $countSkipped++;
                continue;
            }

            // Resolve foreign keys
            $wilayahId   = ($wilayah !== '') ? ($wilayahMap[$wilayah] ?? null) : null;
            $divisionId  = $divisionMap[$division] ?? null;
            $tshirtSizeId = $sizeMap[$tshirtSize] ?? null;

            if ($divisionId === null) {
                $warnings[] = "[$email] Division tidak ditemukan di DB: '$division' — baris dilewati";
                $countSkipped++;
                continue;
            }

            // ── User: create if not exists, fill-in nulls if already exists ──
            $existingUser = User::where('email', $email)->first();

            if ($existingUser === null) {
                // Password = ddmmyyyy from birth date, fallback to 'sks2026' if no birth date
                $passwordRaw = 'sks2026';
                if (!empty($birthDate) && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $birthDate, $m)) {
                    $passwordRaw = $m[3] . $m[2] . $m[1]; // ddmmyyyy
                }

                $existingUser = User::create([
                    'full_name'  => $fullName  ?: $email,
                    'nick_name'  => $nickName  ?: null,
                    'email'      => $email,
                    'password'   => Hash::make($passwordRaw),
                    'role'       => 'member',
                    'phone'      => $phone     ?: null,
                    'birth_date' => $birthDate ?: null,
                    'address'    => $address   ?: null,
                    'wilayah_id' => $wilayahId,
                ]);
                $countCreated++;
            } else {
                // Only backfill fields that are currently empty — never overwrite existing data
                $dirty = false;
                $fill  = [
                    'full_name'  => $fullName,
                    'nick_name'  => $nickName,
                    'phone'      => $phone,
                    'birth_date' => $birthDate,
                    'address'    => $address,
                    'wilayah_id' => $wilayahId,
                ];
                foreach ($fill as $field => $value) {
                    if (empty($existingUser->$field) && !empty($value)) {
                        $existingUser->$field = $value;
                        $dirty = true;
                    }
                }
                if ($dirty) {
                    $existingUser->save();
                }
                // Don't count as "created" — user already existed
            }

            // ── Committee assignment: upsert by (user + period) ───────────────
            CommitteeAssignment::updateOrCreate(
                [
                    'user_id'         => $existingUser->id,
                    'event_period_id' => $period->id,
                ],
                [
                    'division_id'    => $divisionId,
                    'tshirt_size_id' => $tshirtSizeId,
                    'position'       => 'regular',
                    'is_active'      => true,
                ]
            );
            $countAssignment++;
        }

        fclose($handle);

        $this->command->info("✅ Users created  : $countCreated");
        $this->command->info("✅ Assignments     : $countAssignment upserted");
        $this->command->info("⏭️  Rows skipped   : $countSkipped");

        foreach ($warnings as $w) {
            $this->command->warn("  ⚠️  $w");
        }
    }
}
