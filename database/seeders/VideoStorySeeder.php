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
                'slug' => 'uji-coba-plts-terapung-skala-besar',
                'title' => 'Eksklusif: Uji Coba Pemasangan Panel PLTS Terapung Skala Raksasa di Bendungan Nasional',
                'image' => 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?q=80&w=600',
                'duration' => '03:15'
            ],
            [
                'slug' => 'robot-bedah-jarak-jauh-lulus-uji',
                'title' => 'Teknologi: Robot Bedah Jarak Jauh Berbasis Jaringan 6G Sukses Melakukan Jahitan Mikro Pertama',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=600',
                'duration' => '04:42'
            ],
            [
                'slug' => 'peta-retret-yoga-terbaik-bali',
                'title' => 'Vlog Wisata: Menjelajah Resort Retret Yoga Tersembunyi di Perbukitan Ubud',
                'image' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?q=80&w=600',
                'duration' => '06:12'
            ]
        ];

        foreach ($videos as $vid) {
            VideoStory::updateOrCreate(
                ['slug' => $vid['slug']],
                [
                    'title' => $vid['title'],
                    'image' => $vid['image'],
                    'duration' => $vid['duration']
                ]
            );
        }
    }
}
