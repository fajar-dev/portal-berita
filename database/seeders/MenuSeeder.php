<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Parent Root menus
        $home = Menu::create([
            'name' => 'Beranda',
            'url' => '/',
            'order' => 1,
            'is_active' => true,
        ]);

        $politik = Menu::create([
            'name' => 'Politik & Hukum',
            'url' => '/category/politik-hukum',
            'order' => 2,
            'is_active' => true,
        ]);

        $ekonomi = Menu::create([
            'name' => 'Ekonomi & Bisnis',
            'url' => '/category/ekonomi-bisnis',
            'order' => 3,
            'is_active' => true,
        ]);

        $teknologi = Menu::create([
            'name' => 'Teknologi & Sains',
            'url' => '/category/teknologi-sains',
            'order' => 4,
            'is_active' => true,
        ]);

        $lifestyle = Menu::create([
            'name' => 'Gaya Hidup',
            'url' => '/category/gaya-hidup',
            'order' => 5,
            'is_active' => true,
        ]);

        $contact = Menu::create([
            'name' => 'Hubungi Kami',
            'url' => '/contact',
            'order' => 6,
            'is_active' => true,
        ]);

        // 2. Create Dropdown Sub-menus (Child items)
        // Sub-menus under Politik
        Menu::create([
            'parent_id' => $politik->id,
            'name' => 'Nasional',
            'url' => '/search?q=Nasional',
            'order' => 1,
            'is_active' => true,
        ]);
        Menu::create([
            'parent_id' => $politik->id,
            'name' => 'Mancanegara',
            'url' => '/search?q=Mancanegara',
            'order' => 2,
            'is_active' => true,
        ]);

        // Sub-menus under Teknologi
        Menu::create([
            'parent_id' => $teknologi->id,
            'name' => 'Kecerdasan Buatan (AI)',
            'url' => '/search?q=AI',
            'order' => 1,
            'is_active' => true,
        ]);
        Menu::create([
            'parent_id' => $teknologi->id,
            'name' => 'Energi Hijau',
            'url' => '/search?q=EBT',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
