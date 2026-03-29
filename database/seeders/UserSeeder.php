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
            [
                'full_name' => 'Sheren Brigitta Callestya',
                'nick_name' => 'Sheren',
                'email'     => 'sherenbrigitta17@gmail.com',
                'password'  => Hash::make('zxcvzxcv'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Herlina Tanaga',
                'nick_name' => 'Herlina',
                'email'     => 'herlinatanaga@gmail.com',
                'password'  => Hash::make('herlina789'),
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
