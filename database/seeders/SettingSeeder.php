<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    public function run(): void {
        Setting::firstOrCreate(['id' => 1], [
            'posts_per_page' => 10,
            'default_order_by' => 'created_at',
            'default_order_dir' => 'desc',
            'filter_author_id' => null,
            'filter_category_id' => null,
        ]);
    }
}
