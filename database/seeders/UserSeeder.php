<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'full_name' => 'Super Admin',
                'nick_name' => 'S-Admin',
                'email'     => 'superadmin@santoyakobus.org',
                'password'  => Hash::make('zxcvzxcv'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Aucky Riman Halim',
                'nick_name' => 'Aucky',
                'email'     => 'auckyrh@gmail.com',
                'password'  => Hash::make('zxcvzxcv'),
                'role'      => 'superadmin',
            ],

        ];

        foreach ($users as $user) {
            DB::table('users')->insertOrIgnore($user);
        }

        $count = count($users);
        $this->command->info("✅ {$count} user berhasil di-seed!");
    }
}
