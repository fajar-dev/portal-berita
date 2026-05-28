<?php

namespace Database\Seeders;

use App\Models\Opinion;
use Illuminate\Database\Seeder;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opinions = [
            [
                'title' => 'Menjaga Kedaulatan Data Nasional di Era Generative AI',
                'excerpt' => 'Bagaimana Indonesia menyikapi regulasi kepemilikan data pelatihan AI agar tidak menjadi konsumen pasif teknologi asing.',
                'author' => 'Prof. Dr. Hermanto M.Sc',
                'author_avatar' => '/storage/opinions/hermanto.jpg',
                'role' => 'Guru Besar Ilmu Komputasi',
                'published_date' => '28 Mei 2026'
            ],
            [
                'title' => 'Pendidikan Karakter Anak: Benteng Utama di Era Informasi Tak Terbatas',
                'excerpt' => 'Di era AI yang serba instan, nilai integritas, ketekunan, dan empati menjadi keterampilan paling mahal yang harus diajarkan sejak dini.',
                'author' => 'Dr. Elizabeth Tan M.Pd',
                'author_avatar' => '/storage/opinions/elizabeth.jpg',
                'role' => 'Pakar Psikologi Pendidikan',
                'published_date' => '26 Mei 2026'
            ],
            [
                'title' => 'Transisi Energi Bersih: Dimulai dari Piring Makan Kita',
                'excerpt' => 'Melihat keterkaitan emisi gas rumah kaca global dengan pola konsumsi daging sapi dan limbah sisa makanan rumah tangga urban.',
                'author' => 'Rian Adiputra S.Si',
                'author_avatar' => '/storage/avatars/budi_santoso.jpg',
                'role' => 'Aktivis Iklim & Peneliti Ekologi',
                'published_date' => '24 Mei 2026'
            ]
        ];

        foreach ($opinions as $op) {
            Opinion::updateOrCreate(
                ['title' => $op['title']],
                [
                    'excerpt' => $op['excerpt'],
                    'author' => $op['author'],
                    'author_avatar' => $op['author_avatar'],
                    'role' => $op['role'],
                    'published_date' => $op['published_date']
                ]
            );
        }
    }
}
