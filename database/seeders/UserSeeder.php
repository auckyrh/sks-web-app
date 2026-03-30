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
                'full_name' => 'Steven Wijaya',
                'nick_name' => 'SW',
                'email'     => 'swrhythm@gmail.com',
                'password'  => Hash::make('steven789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Wynne Arisandi',
                'nick_name' => 'Wynne',
                'email'     => 'w9679940@gmail.com',
                'password'  => Hash::make('wynne789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Michiko Hanaga Pangestu',
                'nick_name' => 'Michiko',
                'email'     => 'michikohanaga64@gmail.com',
                'password'  => Hash::make('michiko789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Evi Hersanti',
                'nick_name' => 'Evi',
                'email'     => 'evi.hersanti105@gmail.com',
                'password'  => Hash::make('evi789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Maria Elvira Oktavi',
                'nick_name' => 'Elvira',
                'email'     => 'oktavielvira@gmail.com',
                'password'  => Hash::make('elvira789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Herlina Tanaga',
                'nick_name' => 'Herlina',
                'email'     => 'herlinatanaga@gmail.com',
                'password'  => Hash::make('herlina789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Yeni Agusyanti Halim',
                'nick_name' => 'Yeni',
                'email'     => 'yoye4ever@gmail.com',
                'password'  => Hash::make('yeni789'),
                'role'      => 'superadmin',
            ],
            [
                'full_name' => 'Yohana Talan',
                'nick_name' => 'Yolla',
                'email'     => 'Yolla.talan@gmail.com',
                'password'  => Hash::make('yolla789'),
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
