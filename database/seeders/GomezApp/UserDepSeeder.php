<?php

namespace Database\Seeders\GomezApp;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql_gomezapp')->table('usuarios_departamentos')->insert([
            'user_id' => 1,
            'departamento_id' => 38,
            'created_at' => now()
        ]);
    }
}
