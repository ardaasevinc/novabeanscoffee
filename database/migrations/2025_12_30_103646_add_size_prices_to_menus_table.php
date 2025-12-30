<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Mevcut 'price' sütununu 'Small' veya 'Standart' fiyat olarak kabul edebiliriz.
            // Ek boyut fiyatlarını ekleyelim:
            $table->decimal('price_medium', 10, 2)->nullable()->after('price');
            $table->decimal('price_large', 10, 2)->nullable()->after('price_medium');
            
            // Ürünün boyutlu olup olmadığını kontrol etmek için bir flag (isteğe bağlı)
            $table->boolean('has_sizes')->default(false)->after('likes');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['price_medium', 'price_large', 'has_sizes']);
        });
    }
};