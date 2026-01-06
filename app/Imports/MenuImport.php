<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuImport implements ToModel, WithHeadingRow
{
    /**
     * Excel dosyasındaki her bir satır için çalışır.
     */
    public function model(array $row)
    {
        $title = $row['urun_adi'] ?? $row['title'] ?? null;
        
        if (!$title) {
            return null;
        }

        // 1. Kategori Bulma
        $categoryName = $row['kategori'] ?? $row['category'] ?? null;
        $categoryId = null;

        if ($categoryName) {
            $category = MenuCategory::firstOrCreate(
                ['title' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );
            $categoryId = $category->id;
        }

        // 2. Slug Oluşturma
        $slug = $row['slug'] ?? Str::slug($title);
        if (Menu::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(1000, 9999);
        }

        // 3. Yayında mı?
        $isPublished = true;
        if (isset($row['yayinda'])) {
            $val = strtolower($row['yayinda']);
            $isPublished = ($val == 'evet' || $val == '1' || $val == 'true');
        }

        // --- HATA ÇÖZÜMÜ BURADA: FİYAT TEMİZLEME ---
        $rawPrice = $row['fiyat'] ?? $row['price'] ?? 0;
        
        // Gelen değer bir sayı değilse (örn: "₺300,00") temizlik yap
        if (!is_numeric($rawPrice)) {
            // "₺", "TL" ve boşlukları sil
            $rawPrice = str_replace(['₺', 'TL', ' '], '', $rawPrice);
            
            // Eğer binlik ayracı olarak nokta (.) kullanılmışsa onu sil (Örn: 1.250,00 -> 1250,00)
            // Not: Bu mantık Türkiye formatı içindir.
            $rawPrice = str_replace('.', '', $rawPrice);

            // Virgülü (,) noktaya (.) çevir (Örn: 300,00 -> 300.00)
            $rawPrice = str_replace(',', '.', $rawPrice);
        }
        
        $cleanPrice = (float) $rawPrice;
        // -------------------------------------------

        return new Menu([
            'title'            => $title,
            'slug'             => $slug,
            'menu_category_id' => $categoryId,
            'price'            => $cleanPrice, // Temizlenmiş fiyatı kullanıyoruz
            'likes'            => $row['begeni'] ?? $row['likes'] ?? 0,
            'desc'             => $row['aciklama'] ?? $row['desc'] ?? null,
            'img'              => $row['gorsel'] ?? $row['img'] ?? null,
            'meta_title'       => $row['seo_baslik'] ?? null,
            'meta_desc'        => $row['seo_aciklama'] ?? null,
            'is_published'     => $isPublished,
        ]);
    }
}