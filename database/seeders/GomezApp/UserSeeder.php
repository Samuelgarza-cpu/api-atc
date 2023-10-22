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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'role_id' => 1, //SuperAdmin
            'created_at' => now()
        ]);
    }
}
