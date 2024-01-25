<?php

namespace Database\Seeders\GomezApp;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'atc@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 2,
            'created_at' => now()
        ]);
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'ecologia@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 4,
            'created_at' => now()
        ]);
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'bacheo@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 4,
            'created_at' => now()
        ]);
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'basura@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 4,
            'created_at' => now()
        ]);
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 1,
            'created_at' => now()
        ]);
        DB::connection('mysql_gomezapp')->table('users')->insert([
            'email' => 'sp@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 5,
            'created_at' => now()
        ]);
    }
}
