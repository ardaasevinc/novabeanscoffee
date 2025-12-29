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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->string('fname'); // Ad
        $table->string('lname'); // Soyad
        $table->string('email');
        $table->string('phone');
        $table->date('reservation_date');
        $table->string('reservation_time'); // Saat
        $table->string('status')->default('pending'); // pending (bekliyor), approved (onaylandı), declined (red)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
