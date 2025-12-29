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
    Schema::create('heroes', function (Blueprint $table) {
        $table->id();
        
        // Sol Taraf (Görsel/Medya)
        $table->string('image')->nullable();
        $table->string('video_url')->nullable(); // Youtube/Vimeo linki veya dosya yolu
        
        // Sağ Taraf (İçerik)
        $table->string('title');
        $table->string('slug')->nullable(); // Anchor link için kullanılabilir
        $table->string('sub_title')->nullable();
        $table->text('desc')->nullable();
        
        // Butonlar (Route İsimleri tutulacak)
        $table->string('left_btn')->nullable();
        $table->string('right_btn')->nullable();

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
