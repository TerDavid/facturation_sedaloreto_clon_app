<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Insertar roles
        DB::table('roles')->insertOrIgnore([
            [
                'id'         => 1,
                'name'       => 'Administrator',
                'slug'       => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'name'       => 'Técnico',
                'slug'       => 'tecnico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'name'       => 'Cliente',
                'slug'       => 'cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2) Insertar usuario administrador
        DB::table('users')->insert([
            'name'              => 'Srpool',
            'email'             => 'correo@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('del11al11'),
            'role_id'           => 1,
            'remember_token'    => Str::random(10),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
