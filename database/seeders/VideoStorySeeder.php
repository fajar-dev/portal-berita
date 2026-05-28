<?php

namespace Database\Seeders;

use App\Models\VideoStory;
use Illuminate\Database\Seeder;

class VideoStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Eksklusif: Uji Coba Pemasangan Panel PLTS Terapung Skala Raksasa di Bendungan Nasional',
                'iframe_link' => 'https://www.youtube.com/embed/qEV9qvr5TUI?rel=0'
            ],
            [
                'title' => 'Teknologi: Robot Bedah Jarak Jauh Berbasis Jaringan 6G Sukses Melakukan Jahitan Mikro Pertama',
                'iframe_link' => 'https://www.youtube.com/embed/Kqf3366Q-M0?rel=0'
            ],
            [
                'title' => 'Vlog Wisata: Menjelajah Resort Retret Yoga Tersembunyi di Perbukitan Ubud',
                'iframe_link' => 'https://www.youtube.com/embed/f89wHlD93m8?rel=0'
            ]
        ];

        foreach ($videos as $vid) {
            VideoStory::updateOrCreate(
                ['title' => $vid['title']],
                [
                    'iframe_link' => $vid['iframe_link']
                ]
            );
        }
    }
}
