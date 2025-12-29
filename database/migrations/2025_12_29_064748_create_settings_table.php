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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        
        // Görseller (Sol Taraf)
        $table->string('logo')->nullable();
        $table->string('favicon')->nullable();
        $table->string('icon_72x72')->nullable();
        $table->string('icon_192x192')->nullable();
        $table->string('icon_512x512')->nullable();
        $table->string('site_video')->nullable(); // Fileupload

        // Genel Bilgiler (Sağ Taraf)
        $table->string('slogan')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        $table->text('map')->nullable(); // Iframe kodu uzun olabilir
        $table->string('themecolor')->nullable();
        
        // Sosyal Medya
        $table->string('instagram_url')->nullable();
        $table->string('facebook_url')->nullable();
        $table->string('x_url')->nullable(); // Twitter/X

        // SEO ve Footer
        $table->text('footer_text')->nullable();
        $table->string('meta_title')->nullable();
        $table->text('meta_desc')->nullable();
        $table->text('meta_keywords')->nullable();

        // Zorunlu Alan
        $table->boolean('is_published')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
