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
    Schema::create('scroll_tickers', function (Blueprint $table) {
        $table->id();
        
        // Sol Taraf
        $table->string('icon')->nullable();
        
        // Sağ Taraf
        $table->string('text'); // Ana metin
        $table->string('slug')->nullable();
        $table->text('desc')->nullable(); // Detay açıklama
        
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scroll_tickers');
    }
};
