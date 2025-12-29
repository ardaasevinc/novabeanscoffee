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
    Schema::create('why_chooses', function (Blueprint $table) {
        $table->id();

        // Sabit Alanlar (Sağ Taraf)
        $table->string('main_title');
        $table->string('slug')->nullable();
        $table->string('sub_title')->nullable();
        
        // Buton Alanları
        $table->string('btn_text')->nullable();
        $table->string('btn_url')->nullable(); // Route ismini tutacak

        // Foreach Alanı (Icon, Title, Desc listesi)
        $table->json('items')->nullable(); 

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('why_chooses');
    }
};
