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
    Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->boolean('is_liked')->default(true); // 1: Beğendi, 0: Beğenmedi
        $table->string('user_name');
        $table->text('user_comment')->nullable();
        $table->boolean('is_published')->default(false); // Onay mekanizması
        $table->string('ip_address')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
