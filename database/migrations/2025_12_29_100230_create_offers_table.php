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
    Schema::create('offers', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Örn: VIP Yemek Odası
        $table->text('description'); // İçerik metni
        $table->integer('sort')->default(0); // Sıralama
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
