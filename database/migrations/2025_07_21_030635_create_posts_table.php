<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // Kalau user/author dihapus → post ikut hilang
            $table->foreignId('author_id')->constrained(
                table: 'users',
                indexName: 'posts_author_id'
            )->onDelete('cascade');

            // Kalau kategori dihapus → post ikut hilang
            $table->foreignId('category_id')->constrained(
                table: 'categories',
                indexName: 'posts_category_id'
            )->onDelete('cascade');

            $table->string('slug')->unique();
            $table->text('body');
            $table->string('photo')->nullable()->default(null);

            // Tambahan kolom status (draft/published)
            $table->enum('status', ['draft', 'published'])->default('published');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
