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
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150',
                'bio' => 'Jurnalis senior bidang politik dan energi nasional. Berpengalaman lebih dari 12 tahun meliput kebijakan publik di lingkungan parlemen dan kementerian.',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@nusakini.com',
                'username' => 'siti.rahma',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150',
                'bio' => 'Redaktur ekonomi dan keuangan regional. Fokus pada analisis perkembangan UMKM dan penetrasi pasar teknologi finansial di Asia Tenggara.',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@nusakini.com',
                'username' => 'budi.santoso',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150',
                'bio' => 'Koresponden sains dan teknologi masa depan. Gemar menulis ulasan gawai, bio-teknologi, eksplorasi ruang angkasa, dan robotika.',
            ],
            [
                'name' => 'Dwi Handoyo',
                'email' => 'dwi@nusakini.com',
                'username' => 'dwi.handoyo',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150',
                'bio' => 'Reporter olahraga spesialis cabang atletik dan bulutangkis. Memiliki antusiasme tinggi pada perkembangan ilmu latihan fisik atlet.',
            ],
            [
                'name' => 'Laras Ayu',
                'email' => 'laras@nusakini.com',
                'username' => 'laras.ayu',
                'avatar' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=150',
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
