<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Arif Rahman Hakim',
            'profile_photo' => null,
            'username' => 'ariflapar',
            'email' => 'arifrahmanhakim@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Ilham White',
            'profile_photo' => null,
            'username' => 'ilhamwhite',
            'email' => 'ilham@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Eka Tung Tung',
            'profile_photo' => null,
            'username' => 'ekahytam',
            'email' => 'apasiwhite@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'author',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Rendy Pratama',
            'profile_photo' => null,
            'username' => 'rendypratama',
            'email' => 'rendy@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'author',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Ujang Brondol',
            'profile_photo' => null,
            'username' => 'ujang.brondol',
            'email' => 'ujang@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'author',
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Aidul White',
            'profile_photo' => null,
            'username' => 'aidul.white',
            'email' => 'aidulfetjri@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'author',
            'remember_token' => Str::random(10),
        ]);
        User::factory(3)->create();
    }
}
