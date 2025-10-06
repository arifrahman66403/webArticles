<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('posts_per_page')->default(10);
            $table->string('default_order_by')->default('created_at'); // created_at | title | author
            $table->enum('default_order_dir', ['asc','desc'])->default('desc');
            $table->unsignedBigInteger('filter_author_id')->nullable();
            $table->unsignedBigInteger('filter_category_id')->nullable();
            $table->foreign('filter_author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('filter_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('settings');
    }
};