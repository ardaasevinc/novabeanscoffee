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
    Schema::create('abouts', function (Blueprint $table) {
        $table->id();

        // Sabit Alanlar
        $table->string('main_title');
        $table->string('slug')->nullable();
        $table->string('sub_title')->nullable();

        // Foreach Alanı (Icon, Title, Desc listesi burada tutulacak)
        $table->json('features')->nullable(); 

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
