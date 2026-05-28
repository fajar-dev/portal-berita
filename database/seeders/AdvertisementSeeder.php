<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertisement;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = [
            [
                'title' => 'Promo Header Bank Mandiri',
                'position' => 'header',
                'image_url' => '/storage/advertisements/ad_1.jpg',
                'target_url' => 'https://bankmandiri.co.id',
                'is_active' => true,
            ],
            [
                'title' => 'Iklan Sidebar Kanan - Telkomsel',
                'position' => 'sidebar',
                'image_url' => '/storage/advertisements/ad_2.jpg',
                'target_url' => 'https://telkomsel.com',
                'is_active' => true,
            ],
            [
                'title' => 'Iklan Tengah Beranda - Shopee',
                'position' => 'home_middle',
                'image_url' => '/storage/advertisements/ad_3.jpg',
                'target_url' => 'https://shopee.co.id',
                'is_active' => true,
            ],
            [
                'title' => 'Iklan Dalam Artikel - Traveloka',
                'position' => 'article_inline',
                'image_url' => '/storage/advertisements/ad_4.jpg',
                'target_url' => 'https://traveloka.com',
                'is_active' => true,
            ]
        ];

        foreach ($ads as $ad) {
            Advertisement::create($ad);
        }
    }
}
