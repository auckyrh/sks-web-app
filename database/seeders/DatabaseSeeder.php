<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'full_name' => 'Super Admin',
            'email'     => 'superadmin@santoyakobus.org',
            'password'  => Hash::make('zxcvzxcv'),
            'role'      => 'superadmin',
        ]);

        $this->call([
            WilayahLingkunganSeeder::class,
            DivisionSeeder::class,
            GatheringTypeSeeder::class,
            EventPeriodSeeder::class,
        ]);

        // User::factory(10)->create();
    }
}
