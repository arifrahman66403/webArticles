<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if (! function_exists('generate_unique_slug')) {
    /**
     * Generate unique slug untuk tabel tertentu.
     *
     * @param string $title  Judul atau teks dasar slug
     * @param string $table  Nama tabel (mis: 'posts' atau 'categories')
     * @param int|null $ignoreId  ID yang diabaikan (saat update)
     * @return string
     */
    function generate_unique_slug(string $title, string $table, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $newSlug = $baseSlug;

        while (
            DB::table($table)
                ->where('slug', $newSlug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $newSlug = $baseSlug . '-' . rand(1000, 9999);
        }

        return $newSlug;
    }
}
