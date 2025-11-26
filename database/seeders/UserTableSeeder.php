<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // admin
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('staffpassword'),
                'role' => 'staff'
            ],
            [
                'name' => 'cordinator',
                'email' => 'cordinator@gmail.com',
                'password' => Hash::make('cordinatorpassword'),
                'role' => 'cordinator'
            ],
            [
                'name' => 'auditor',
                'email' => 'auditor@gmail.com',
                'password' => Hash::make('auditorpassword'),
                'role' => 'auditor'
            ],

        ]);
    }
}
