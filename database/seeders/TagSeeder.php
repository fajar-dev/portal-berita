<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsData = [
            'EBT' => 'ebt',
            'Energi Hijau' => 'energi-hijau',
            'Kebijakan Publik' => 'kebijakan-publik',
            'UMKM' => 'umkm',
            'Digitalisasi' => 'digitalisasi',
            'Ekonomi' => 'ekonomi',
            'Teknologi Medis' => 'teknologi-medis',
            'AI Medis' => 'ai-medis',
            'Sains' => 'sains',
            'Sport Science' => 'sport-science',
            'Kesehatan' => 'kesehatan',
            'Bulutangkis' => 'bulutangkis',
            'Gaya Hidup' => 'gaya-hidup',
            'Kesehatan Mental' => 'kesehatan-mental',
            'Wellness' => 'wellness',
        ];

        $tags = [];
        foreach ($tagsData as $name => $slug) {
            $tags[$slug] = Tag::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        // Map tags to seeded articles based on slugs
        $mappings = [
            'reformasi-regulasi-energi-hijau' => ['ebt', 'energi-hijau', 'kebijakan-publik'],
            'ekonomi-digital-melaju-pesat' => ['umkm', 'digitalisasi', 'ekonomi'],
            'mengintip-masa-depan-ai-medis' => ['teknologi-medis', 'ai-medis', 'sains'],
            'kebangkitan-sport-science-atlet' => ['sport-science', 'kesehatan', 'bulutangkis'],
            'seni-menemukan-ketenangan-wellness-travel' => ['gaya-hidup', 'kesehatan-mental', 'wellness'],
            'ktt-iklim-global-sepakati-pendanaan' => ['energi-hijau', 'kebijakan-publik'],
            'evolusi-jaringan-6g-iot' => ['digitalisasi', 'sains'],
            'investasi-infrastruktur-transportasi-massal' => ['ekonomi', 'kebijakan-publik'],
            'kebangkitan-badminton-junior' => ['bulutangkis', 'kesehatan']
        ];

        foreach ($mappings as $slug => $tagSlugs) {
            $article = Article::where('slug', $slug)->first();
            if ($article) {
                $ids = [];
                foreach ($tagSlugs as $ts) {
                    if (isset($tags[$ts])) {
                        $ids[] = $tags[$ts]->id;
                    }
                }
                $article->tags()->sync($ids);
            }
        }
    }
}
