<?php

namespace Database\Seeders;

use App\Models\Infographic;
use Illuminate\Database\Seeder;

class InfographicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infographics = [
            [
                'title' => 'Peta Target Transisi Energi Baru Terbarukan Indonesia 2026 - 2060',
                'image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=600',
                'slug' => 'peta-target-transisi-ebt-indonesia'
            ],
            [
                'title' => 'Infografis: Evolusi Jaringan Telekomunikasi Nirkabel 1G Menuju Era 6G',
                'image' => 'https://images.unsplash.com/photo-1544256718-3bcf237f3974?q=80&w=600',
                'slug' => 'evolusi-jaringan-nirkabel-6g'
            ],
            [
                'title' => 'Rute Kereta Cepat Lintas Trans-Sumatera: Rencana Megaproyek Dekade Ini',
                'image' => 'https://images.unsplash.com/photo-1515162305285-0293e4767cc2?q=80&w=600',
                'slug' => 'rute-kereta-cepat-trans-sumatera'
            ]
        ];

        foreach ($infographics as $info) {
            Infographic::updateOrCreate(
                ['slug' => $info['slug']],
                [
                    'title' => $info['title'],
                    'image' => $info['image']
                ]
            );
        }
    }
}
