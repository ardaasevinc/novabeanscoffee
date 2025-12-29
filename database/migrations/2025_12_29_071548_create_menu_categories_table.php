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
    Schema::create('menu_categories', function (Blueprint $table) {
        $table->id();

        // Sol Taraf (Medya)
        $table->string('img')->nullable(); // 1920x768 Banner

        // Sağ Taraf (İçerik)
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('desc')->nullable();

        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_categories');
    }
};
