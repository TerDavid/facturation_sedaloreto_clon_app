<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserClasificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_clasification')->insert([
            ['name' => 'Activos'],
            ['name' => 'Factibles'],
            ['name' => 'Potenciales'],
            ['name' => 'Clandestinos'],
        ]);
    }
}
