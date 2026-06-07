# Team Assignment — Distribusi Kelompok SKS

Dokumen ini menjelaskan cara kerja sistem distribusi peserta ke tim/kelompok,
dan cara mengkonfigurasinya untuk tahun-tahun berikutnya.

---

## Alur Kerja Setiap Tahun

```
1. Buka pendaftaran → peserta mendaftar
2. Admin verifikasi pembayaran (payment_status = verified)
3. Generate Peserta  → Admin > Registrasi > "Generate Semua Peserta"
4. Generate Tim      → seeder TeamAssignmentConstraintXXXXSeeder (lihat bawah)
5. Distribusi        → Admin > Distribusi Kelompok > "Generate Otomatis"
6. Manual adjustment → tombol "Pindah" per peserta jika perlu
7. Halaman publik /{year}/kelompok otomatis tampil begitu peserta ada di tim
```

---

## Cara Menambah Constraint untuk Tahun Baru

1. Buat file seeder baru, contoh:
   ```
   database/seeders/TeamAssignmentConstraint2027Seeder.php
   ```
   Ikuti pola `TeamAssignmentConstraint2027Seeder.php` yang sudah ada.

2. Isi constraint dengan data permintaan khusus dari panitia/orang tua.

3. Jalankan seeder **setelah** tim sudah dibuat untuk periode tersebut:
   ```bash
   php artisan db:seed --class=TeamAssignmentConstraint2027Seeder
   ```

4. Atau tambah constraint langsung via Admin > **Constraint Tim**.

---

## Tipe Constraint

### `same_team`
Dua atau lebih peserta harus berada di tim yang **sama** (tim manapun).

**Kapan digunakan:** Permintaan orang tua agar anak-anaknya/temannya satu kelompok.

**Contoh:**
```json
{
  "type": "same_team",
  "registration_numbers": ["SKS-2026-0080", "SKS-2026-0288"],
  "notes": "Permintaan orang tua agar satu kelompok (Kelas Kecil)."
}
```

### `fixed_team`
Satu atau lebih peserta harus ditempatkan di **tim tertentu** (fixed_team_id).

**Kapan digunakan:** Kebutuhan khusus, misalnya anak berkebutuhan khusus yang
pendampingnya perlu duduk di posisi tertentu (baris belakang, dsb.).

**Contoh:**
```json
{
  "type": "fixed_team",
  "registration_numbers": ["SKS-2026-0292"],
  "fixed_team_id": 42,
  "notes": "Ada suster pendamping. Ditempatkan di tim nomor terakhir agar suster dapat duduk di barisan belakang."
}
```

---

## Algoritma Distribusi (`TeamAssignmentService`)

### Phase A — Fixed Team
Peserta dengan constraint `fixed_team` langsung di-assign ke `fixed_team_id`.
Dilakukan pertama sebelum fase lain agar slot tim tersebut sudah terisi.

### Phase B — Same Team
Untuk setiap constraint `same_team`:
- Cari tim di kelas yang sama yang memiliki cukup ruang untuk seluruh grup.
- Jika tidak ada tim dengan ruang cukup, tempatkan di tim dengan ruang terbanyak
  (akan sedikit melebihi target — bisa di-adjust manual).

### Phase C — Balanced Distribution
Sisa peserta didistribusikan dengan pendekatan **greedy fill**:

1. **Sort peserta** per kelas:
   - Perempuan (P) dahulu, laki-laki (L) belakangan
     *(karena jumlah P jauh lebih banyak; ini memastikan setiap tim dapat P dari
     berbagai wilayah sebelum L mulai diisi)*
   - Per gender: urutkan by `wilayah_id` ascending (null/luar paroki = paling akhir)
   - Per wilayah: urutkan by `grade` ascending

2. **Fill greedily**: Untuk setiap peserta dari list yang sudah di-sort:
   - Pilih tim dengan **sisa slot terbanyak** (target − current_count)
   - Jika seri, pilih tim dengan **nomor lebih kecil**
     *(ini memastikan tim nomor kecil dapat anggota lebih banyak ketika total
     tidak habis dibagi)*

### Aturan ukuran tim

Tim bernomor kecil mendapat anggota **lebih banyak** ketika total tidak habis dibagi.

**Rumus:**
```
base  = floor(total_peserta_kelas / jumlah_tim)
extra = total_peserta_kelas % jumlah_tim

Tim ke-i (index 0):
  target = base + (1 jika i < extra, else 0)
```

**Contoh — Kelas Besar: 98 peserta / 10 tim:**
```
base = 9, extra = 8
Tim 1–8  → target 10 anggota
Tim 9–10 → target 9 anggota
```

---

## Halaman Admin

| Halaman | URL | Fungsi |
|---------|-----|--------|
| Distribusi Kelompok | `/admin/distribusi-kelompok` | Generate + lihat hasil + swap peserta |
| Constraint Tim | `/admin/team-assignment-constraints` | CRUD constraint khusus |
| Tim / Kelompok | `/admin/tim-kelompoks` | Detail per tim |

---

## Constraint SKS 2026

| # | Tipe | Peserta | Keterangan |
|---|------|---------|------------|
| a | same_team | 0280 + 0281 | Jane Airene & Carren Purnomo (Kelas Besar) |
| b | same_team | 0080 + 0288 | Yovela Valentine Octora & Kim Reina Pontoh (Kelas Kecil) |
| c | same_team | 0311 + 0265 | Vanessa Irish Soewignyo & Elysia Angelin Laij (Kelas Kecil) |
| d | same_team | 0034 + 0004 | Celine Yang & Fabiola Aerilyn Bellvania (Kelas Besar) |
| e | fixed_team | 0292 | Rafael Andi Sutanto → Carlo Acutis 10 (suster pendamping) |

---

## Catatan Penting

- **Re-run aman**: "Generate Otomatis" mereset semua `team_id` dulu sebelum redistribute.
  Tampilkan konfirmasi ke admin sebelum re-run jika sudah ada assignment.
- **Halaman publik**: `/{year}/kelompok` otomatis menampilkan data begitu peserta
  sudah di-assign ke tim. Tidak ada toggle publish terpisah.
- **Lintas tahun**: Semua data di-scope by `event_period_id`. Menjalankan distribusi
  untuk SKS 2027 tidak akan memengaruhi data SKS 2026.
