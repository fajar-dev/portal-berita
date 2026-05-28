<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Andika Wijaya',
                'email' => 'andika@nusakini.com',
                'username' => 'andika.wijaya',
                'avatar' => '/storage/avatars/andika_wijaya.jpg',
                'bio' => 'Jurnalis senior bidang politik dan energi nasional. Berpengalaman lebih dari 12 tahun meliput kebijakan publik di lingkungan parlemen dan kementerian.',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@nusakini.com',
                'username' => 'siti.rahma',
                'avatar' => '/storage/avatars/siti_rahma.jpg',
                'bio' => 'Redaktur ekonomi dan keuangan regional. Fokus pada analisis perkembangan UMKM dan penetrasi pasar teknologi finansial di Asia Tenggara.',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@nusakini.com',
                'username' => 'budi.santoso',
                'avatar' => '/storage/avatars/budi_santoso.jpg',
                'bio' => 'Koresponden sains dan teknologi masa depan. Gemar menulis ulasan gawai, bio-teknologi, eksplorasi ruang angkasa, dan robotika.',
            ],
            [
                'name' => 'Dwi Handoyo',
                'email' => 'dwi@nusakini.com',
                'username' => 'dwi.handoyo',
                'avatar' => '/storage/avatars/dwi_handoyo.jpg',
                'bio' => 'Reporter olahraga spesialis cabang atletik dan bulutangkis. Memiliki antusiasme tinggi pada perkembangan ilmu latihan fisik atlet.',
            ],
            [
                'name' => 'Laras Ayu',
                'email' => 'laras@nusakini.com',
                'username' => 'laras.ayu',
                'avatar' => '/storage/avatars/laras_ayu.jpg',
                'bio' => 'Kontributor rubrik gaya hidup sehat, seni budaya, arsitektur hijau, dan kuliner eksotis. Penjelajah wisata kesehatan indonesia.',
            ]
        ];

        foreach ($authors as $author) {
            User::updateOrCreate(
                ['email' => $author['email']],
                [
                    'name' => $author['name'],
                    'username' => $author['username'],
                    'avatar' => $author['avatar'],
                    'bio' => $author['bio'],
                    'password' => Hash::make('password') // default password
                ]
            );
        }
    }
}
