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
    Schema::create('blogs', function (Blueprint $table) {
        $table->id();

        // İlişki (Hangi kategoriye ait?)
        $table->foreignId('blog_category_id')->nullable()->constrained('blog_categories')->nullOnDelete();

        // Sol Taraf (Görsel ve Etiketler)
        $table->string('img')->nullable();
        $table->json('tags')->nullable(); // Etiketler JSON olarak tutulacak

        // Sağ Taraf (İçerik)
        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('desc')->nullable(); // Blog yazısı uzun olabilir, longText iyidir

        // SEO Alanları
        $table->string('meta_title')->nullable();
        $table->text('meta_desc')->nullable();
        $table->text('meta_keywords')->nullable(); // "meta_words" yerine standart olan keywords kullandım

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
