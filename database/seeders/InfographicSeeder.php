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
                'image' => '/storage/infographics/ebt.jpg',
                'slug' => 'peta-target-transisi-ebt-indonesia'
            ],
            [
                'title' => 'Infografis: Evolusi Jaringan Telekomunikasi Nirkabel 1G Menuju Era 6G',
                'image' => '/storage/infographics/telecom.jpg',
                'slug' => 'evolusi-jaringan-nirkabel-6g'
            ],
            [
                'title' => 'Rute Kereta Cepat Lintas Trans-Sumatera: Rencana Megaproyek Dekade Ini',
                'image' => '/storage/infographics/train.jpg',
                'slug' => 'rute-kereta-cepat-trans-sumatera'
            ],
            [
                'title' => 'Infografis: Potensi Pertumbuhan Sektor Ekonomi Digital & FinTech Nasional',
                'image' => '/storage/infographics/dashboard.jpg',
                'slug' => 'potensi-pertumbuhan-ekonomi-digital-fintech'
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
