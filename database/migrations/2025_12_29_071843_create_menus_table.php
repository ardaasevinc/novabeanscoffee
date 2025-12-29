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
    Schema::create('menus', function (Blueprint $table) {
        $table->id();

        // İlişki (Hangi kategoriye ait?)
        $table->foreignId('menu_category_id')->constrained('menu_categories')->cascadeOnDelete();

        // Sol Taraf (Medya ve Sayısal Veriler)
        $table->string('img')->nullable();
        $table->decimal('price', 10, 2)->default(0); // Örn: 150.00
        $table->integer('likes')->default(0); // Beğeni sayısı

        // Sağ Taraf (İçerik)
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('desc')->nullable();

        // SEO Alanları
        $table->string('meta_title')->nullable();
        $table->text('meta_desc')->nullable();
        $table->text('meta_keywords')->nullable();

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
