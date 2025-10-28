<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_profiles')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tambahkan data admin
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Administrator Dunia Virtual',
            'email' => 'admin@virtualworld.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan profil admin
        DB::table('user_profiles')->insert([
            'user_id' => $adminId,
            'address' => 'Metaverse Tower, Virtual City',
            'phone' => '000-ADMIN-VR',
            'avatar' => 'admin-avatar.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data user biasa
        $userId = DB::table('users')->insertGetId([
            'name' => 'Pengguna Dunia Virtual',
            'email' => 'user@virtualworld.test',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan profil user
        DB::table('user_profiles')->insert([
            'user_id' => $userId,
            'address' => 'Sector 7, Virtual World',
            'phone' => '081234567890',
            'avatar' => 'user-avatar.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
