<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Category::create([
        //     'name' => 'Web Programming',
        //     'slug' => 'web-programming'
        // ]);

        // Post::create([
        //     'title' => 'Judul Postingan Pertama',
        //     'author_id' => 1,
        //     'category_id' => 1,
        //     'slug' => 'judul-postingan-pertama',
        //     'body' => 'Ini adalah isi lengkap dari postingan pertama. Postingan ini dibuat untuk tujuan demonstrasi.
        //     Postingan ini akan memberikan contoh bagaimana cara membuat postingan dengan konten yang cukup panjang. 
        //     Anda dapat menambahkan lebih banyak teks di sini untuk mengisi ruang dan memberikan informasi yang lebih lengkap kepada pembaca. 
        //     Pastikan untuk menggunakan paragraf yang terstruktur dengan baik agar mudah dibaca.'
        // ]);

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SettingSeeder::class, // tambahkan ini
        ]);
        Post::factory(592)->create();
    }
}