<?php

namespace Database\Seeders;

use App\Models\EventPeriod;
use App\Models\Lingkungan;
use App\Models\PaymentTier;
use App\Models\Registration;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $period = EventPeriod::where('year', 2026)->firstOrFail();
        $tiers  = PaymentTier::where('event_period_id', $period->id)->pluck('id')->toArray();

        $wilayahs = Wilayah::with('lingkungan')->get();

        $children = [
            ['child_full_name' => 'Alexander Kevin Santoso',    'nickname' => 'Alex',    'gender' => 'M', 'birth_date' => '2016-03-12', 'grade' => 4],
            ['child_full_name' => 'Brigitta Natalia Wijaya',     'nickname' => 'Britta',  'gender' => 'F', 'birth_date' => '2017-07-05', 'grade' => 3],
            ['child_full_name' => 'Christopher Daniel Lim',      'nickname' => 'Chris',   'gender' => 'M', 'birth_date' => '2015-11-20', 'grade' => 5],
            ['child_full_name' => 'Devina Anastasia Hartono',    'nickname' => 'Devi',    'gender' => 'F', 'birth_date' => '2018-01-30', 'grade' => 2],
            ['child_full_name' => 'Evan Michael Setiawan',       'nickname' => 'Evan',    'gender' => 'M', 'birth_date' => '2016-09-14', 'grade' => 4],
            ['child_full_name' => 'Felicia Grace Tanoto',        'nickname' => 'Feli',    'gender' => 'F', 'birth_date' => '2019-04-22', 'grade' => 1],
            ['child_full_name' => 'Gabriel Joshua Kusuma',       'nickname' => 'Gabe',    'gender' => 'M', 'birth_date' => '2017-12-08', 'grade' => 3],
            ['child_full_name' => 'Hannah Maria Susanto',        'nickname' => 'Hannah',  'gender' => 'F', 'birth_date' => '2015-06-17', 'grade' => 5],
            ['child_full_name' => 'Ivan Cornelius Pranoto',      'nickname' => 'Ivan',    'gender' => 'M', 'birth_date' => '2018-08-03', 'grade' => 2],
            ['child_full_name' => 'Jessica Aurelia Halim',       'nickname' => 'Jess',    'gender' => 'F', 'birth_date' => '2016-02-25', 'grade' => 4],
            ['child_full_name' => 'Kevin Nathaniel Wahyu',       'nickname' => 'Kevin',   'gender' => 'M', 'birth_date' => '2014-10-11', 'grade' => 6],
            ['child_full_name' => 'Laura Theresa Gunawan',       'nickname' => 'Laura',   'gender' => 'F', 'birth_date' => '2019-05-19', 'grade' => 1],
            ['child_full_name' => 'Matthew Andreas Salim',       'nickname' => 'Matt',    'gender' => 'M', 'birth_date' => '2017-03-27', 'grade' => 3],
            ['child_full_name' => 'Natasha Olivia Christianto',  'nickname' => 'Nata',    'gender' => 'F', 'birth_date' => '2015-09-09', 'grade' => 5],
            ['child_full_name' => 'Owen Benedict Tanujaya',      'nickname' => 'Owen',    'gender' => 'M', 'birth_date' => '2018-11-14', 'grade' => 2],
            ['child_full_name' => 'Patricia Elaine Wibowo',      'nickname' => 'Patty',   'gender' => 'F', 'birth_date' => '2016-07-31', 'grade' => 4],
            ['child_full_name' => 'Quincy Rafael Santoso',       'nickname' => 'Quinn',   'gender' => 'M', 'birth_date' => '2014-04-06', 'grade' => 6],
            ['child_full_name' => 'Rachel Stephanie Limanto',    'nickname' => 'Rachel',  'gender' => 'F', 'birth_date' => '2017-08-23', 'grade' => 3],
            ['child_full_name' => 'Sebastian Timothy Kurnia',    'nickname' => 'Seba',    'gender' => 'M', 'birth_date' => '2015-01-16', 'grade' => 5],
            ['child_full_name' => 'Theresia Viola Handoyo',      'nickname' => 'Viola',   'gender' => 'F', 'birth_date' => '2019-10-02', 'grade' => 1],
            // Batch 2 — all pending
            ['child_full_name' => 'Albertus Rizky Permana',      'nickname' => 'Alby',    'gender' => 'M', 'birth_date' => '2016-05-18', 'grade' => 4],
            ['child_full_name' => 'Bernadette Sari Nugraha',      'nickname' => 'Berna',   'gender' => 'F', 'birth_date' => '2018-02-11', 'grade' => 2],
            ['child_full_name' => 'Cornelius Bagas Santoso',      'nickname' => 'Bagas',   'gender' => 'M', 'birth_date' => '2015-08-29', 'grade' => 5],
            ['child_full_name' => 'Dominica Putri Rahayu',        'nickname' => 'Putri',   'gender' => 'F', 'birth_date' => '2017-04-03', 'grade' => 3],
            ['child_full_name' => 'Edwardus Fabian Kurniawan',    'nickname' => 'Fabian',  'gender' => 'M', 'birth_date' => '2019-11-07', 'grade' => 1],
            ['child_full_name' => 'Fransisca Dewi Puspita',       'nickname' => 'Dewi',    'gender' => 'F', 'birth_date' => '2014-06-24', 'grade' => 6],
            ['child_full_name' => 'Gregorius Hendra Saputra',     'nickname' => 'Hendra',  'gender' => 'M', 'birth_date' => '2016-12-15', 'grade' => 4],
            ['child_full_name' => 'Helena Cinta Pratiwi',         'nickname' => 'Cinta',   'gender' => 'F', 'birth_date' => '2018-09-01', 'grade' => 2],
            ['child_full_name' => 'Ignatius Bimo Wicaksono',      'nickname' => 'Bimo',    'gender' => 'M', 'birth_date' => '2015-03-20', 'grade' => 5],
            ['child_full_name' => 'Josephine Ratna Dewanti',      'nickname' => 'Ratna',   'gender' => 'F', 'birth_date' => '2017-10-13', 'grade' => 3],
            ['child_full_name' => 'Krisantus Damar Wulandari',    'nickname' => 'Damar',   'gender' => 'M', 'birth_date' => '2014-01-08', 'grade' => 6],
            ['child_full_name' => 'Lidwina Eka Setiawati',        'nickname' => 'Eka',     'gender' => 'F', 'birth_date' => '2019-07-26', 'grade' => 1],
            ['child_full_name' => 'Martinus Gilang Prabowo',      'nickname' => 'Gilang',  'gender' => 'M', 'birth_date' => '2016-04-10', 'grade' => 4],
            ['child_full_name' => 'Nikolaus Rendi Firmansyah',    'nickname' => 'Rendi',   'gender' => 'M', 'birth_date' => '2018-06-05', 'grade' => 2],
            ['child_full_name' => 'Oktavia Rena Kusumawati',      'nickname' => 'Rena',    'gender' => 'F', 'birth_date' => '2015-12-30', 'grade' => 5],
            ['child_full_name' => 'Philipus Andro Wibisono',      'nickname' => 'Andro',   'gender' => 'M', 'birth_date' => '2017-02-17', 'grade' => 3],
            ['child_full_name' => 'Quentina Rosa Maharani',       'nickname' => 'Rosa',    'gender' => 'F', 'birth_date' => '2019-03-14', 'grade' => 1],
            ['child_full_name' => 'Robertus Hasan Sulistyo',      'nickname' => 'Hasan',   'gender' => 'M', 'birth_date' => '2014-09-22', 'grade' => 6],
            ['child_full_name' => 'Stella Maris Anggraeni',       'nickname' => 'Stella',  'gender' => 'F', 'birth_date' => '2016-08-06', 'grade' => 4],
            ['child_full_name' => 'Timotius Bagus Hermawan',      'nickname' => 'Bagus',   'gender' => 'M', 'birth_date' => '2018-05-19', 'grade' => 2],
        ];

        $parents = [
            ['parent_name' => 'Bapak Antonius Santoso',    'parent_whatsapp' => '08111000001'],
            ['parent_name' => 'Ibu Maria Wijaya',          'parent_whatsapp' => '08111000002'],
            ['parent_name' => 'Bapak Thomas Lim',          'parent_whatsapp' => '08111000003'],
            ['parent_name' => 'Ibu Yohana Hartono',        'parent_whatsapp' => '08111000004'],
            ['parent_name' => 'Bapak Petrus Setiawan',     'parent_whatsapp' => '08111000005'],
            ['parent_name' => 'Ibu Agnes Tanoto',          'parent_whatsapp' => '08111000006'],
            ['parent_name' => 'Bapak Markus Kusuma',       'parent_whatsapp' => '08111000007'],
            ['parent_name' => 'Ibu Theresia Susanto',      'parent_whatsapp' => '08111000008'],
            ['parent_name' => 'Bapak Paulus Pranoto',      'parent_whatsapp' => '08111000009'],
            ['parent_name' => 'Ibu Christina Halim',       'parent_whatsapp' => '08111000010'],
            ['parent_name' => 'Bapak Benediktus Wahyu',    'parent_whatsapp' => '08111000011'],
            ['parent_name' => 'Ibu Veronika Gunawan',      'parent_whatsapp' => '08111000012'],
            ['parent_name' => 'Bapak Andreas Salim',       'parent_whatsapp' => '08111000013'],
            ['parent_name' => 'Ibu Margareta Christianto', 'parent_whatsapp' => '08111000014'],
            ['parent_name' => 'Bapak Yoseph Tanujaya',     'parent_whatsapp' => '08111000015'],
            ['parent_name' => 'Ibu Lucia Wibowo',          'parent_whatsapp' => '08111000016'],
            ['parent_name' => 'Bapak Ignatius Santoso',    'parent_whatsapp' => '08111000017'],
            ['parent_name' => 'Ibu Elisabet Limanto',      'parent_whatsapp' => '08111000018'],
            ['parent_name' => 'Bapak Stefanus Kurnia',     'parent_whatsapp' => '08111000019'],
            ['parent_name' => 'Ibu Katharina Handoyo',     'parent_whatsapp' => '08111000020'],
            // Batch 2
            ['parent_name' => 'Bapak Albertus Permana',     'parent_whatsapp' => '08111000021'],
            ['parent_name' => 'Ibu Bernadette Nugraha',     'parent_whatsapp' => '08111000022'],
            ['parent_name' => 'Bapak Cornelius Santoso',    'parent_whatsapp' => '08111000023'],
            ['parent_name' => 'Ibu Dominica Rahayu',        'parent_whatsapp' => '08111000024'],
            ['parent_name' => 'Bapak Edwardus Kurniawan',   'parent_whatsapp' => '08111000025'],
            ['parent_name' => 'Ibu Fransisca Puspita',      'parent_whatsapp' => '08111000026'],
            ['parent_name' => 'Bapak Gregorius Saputra',    'parent_whatsapp' => '08111000027'],
            ['parent_name' => 'Ibu Helena Pratiwi',         'parent_whatsapp' => '08111000028'],
            ['parent_name' => 'Bapak Ignatius Wicaksono',   'parent_whatsapp' => '08111000029'],
            ['parent_name' => 'Ibu Josephine Dewanti',      'parent_whatsapp' => '08111000030'],
            ['parent_name' => 'Bapak Krisantus Wulandari',  'parent_whatsapp' => '08111000031'],
            ['parent_name' => 'Ibu Lidwina Setiawati',      'parent_whatsapp' => '08111000032'],
            ['parent_name' => 'Bapak Martinus Prabowo',     'parent_whatsapp' => '08111000033'],
            ['parent_name' => 'Bapak Nikolaus Firmansyah',  'parent_whatsapp' => '08111000034'],
            ['parent_name' => 'Ibu Oktavia Kusumawati',     'parent_whatsapp' => '08111000035'],
            ['parent_name' => 'Bapak Philipus Wibisono',    'parent_whatsapp' => '08111000036'],
            ['parent_name' => 'Ibu Quentina Maharani',      'parent_whatsapp' => '08111000037'],
            ['parent_name' => 'Bapak Robertus Sulistyo',    'parent_whatsapp' => '08111000038'],
            ['parent_name' => 'Ibu Stella Anggraeni',       'parent_whatsapp' => '08111000039'],
            ['parent_name' => 'Bapak Timotius Hermawan',    'parent_whatsapp' => '08111000040'],
        ];

        $sizes   = ['S', 'M', 'L', 'XL', '2XL'];
        $sources = ['BIAK', 'YCK', 'UMUM'];

        // Batch 2: all pending, random created_at between Apr 3–10 2026
        $batch2StatusSets = array_fill(0, 20, ['payment_status' => 'pending', 'status' => 'pending']);

        // Mix of statuses so there's useful seed data to work with
        $statusSets = [
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'verified', 'status' => 'confirmed'],
            ['payment_status' => 'rejected', 'status' => 'pending'],
            ['payment_status' => 'rejected', 'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
            ['payment_status' => 'pending',  'status' => 'pending'],
        ];

        $wilayahList    = $wilayahs->all();
        $lingkunganAll  = Lingkungan::all();
        $year           = 2026;
        $created        = 0;

        foreach ($children as $i => $child) {
            $wilayah    = $wilayahList[$i % count($wilayahList)];
            $lingkungan = $lingkunganAll->where('wilayah_id', $wilayah->id)->first();
            $isBatch2   = $i >= 20;
            $statuses   = $isBatch2 ? $batch2StatusSets[$i - 20] : $statusSets[$i];
            $tierId     = $tiers[$i % count($tiers)];
            $amount     = PaymentTier::find($tierId)->amount;

            $paddedNum  = str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $regNumber  = "SKS-{$year}-{$paddedNum}";

            if (Registration::where('registration_number', $regNumber)->exists()) {
                continue;
            }

            $reg = Registration::create([
                'event_period_id'     => $period->id,
                'registration_number' => $regNumber,
                'child_full_name'     => $child['child_full_name'],
                'nickname'            => $child['nickname'],
                'gender'              => $child['gender'],
                'birth_date'          => $child['birth_date'],
                'grade'               => $child['grade'],
                'address'             => 'Jl. Contoh No. ' . ($i + 1) . ', Jakarta',
                'wilayah_id'          => $wilayah->id,
                'lingkungan_id'       => $lingkungan?->id,
                'registration_source' => $sources[$i % count($sources)],
                'has_joined_biak_yck' => $i % 3 !== 0,
                'tshirt_size'         => $sizes[$i % count($sizes)],
                'parent_name'         => $parents[$i]['parent_name'],
                'parent_whatsapp'     => $parents[$i]['parent_whatsapp'],
                'allergies'           => $i % 5 === 0 ? 'Seafood' : null,
                'notes'               => null,
                'payment_tier_id'     => $tierId,
                'payment_amount'      => $amount,
                'donation_amount'     => $i % 4 === 0 ? 50000 : 0,
                'payment_proof_path'  => null,
                'payment_status'      => $statuses['payment_status'],
                'status'              => $statuses['status'],
                'created_by'          => 1,
            ]);

            if ($isBatch2) {
                $randomCreatedAt = Carbon::create(2026, 4, rand(3, 10), rand(7, 22), rand(0, 59), rand(0, 59));
                $reg->timestamps = false;
                $reg->created_at = $randomCreatedAt;
                $reg->save();
            }

            $created++;
        }

        $this->command->info("✅ {$created} registrasi berhasil di-seed!");
    }
}
