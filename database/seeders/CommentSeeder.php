<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commentsData = [
            'reformasi-regulasi-energi-hijau' => [
                [
                    'name' => 'Faisal Haris',
                    'email' => 'faisal.haris@gmail.com',
                    'body' => 'Kebijakan yang sangat dinanti. Transisi energi hijau di Indonesia memang lambat tapi langkah regulasi seperti ini adalah fondasi yang bagus.',
                    'created_at' => now()->subHours(5),
                    'replies' => [
                        [
                            'name' => 'Budi Santoso',
                            'email' => 'budi.santoso@gmail.com',
                            'body' => 'Betul sekali, Mas Faisal! Apalagi kalau insentif pajaknya diperbesar.',
                            'created_at' => now()->subHours(4),
                        ]
                    ]
                ],
                [
                    'name' => 'Dewi Lestari',
                    'email' => 'dewi.lestari@yahoo.co.id',
                    'body' => 'Semoga penerapannya konsisten di lapangan, jangan sampai aturan tumpang tindih dengan industri batu bara.',
                    'created_at' => now()->subHours(2),
                ]
            ],
            'ekonomi-digital-melaju-pesat' => [
                [
                    'name' => 'Rian Kurniawan',
                    'email' => 'rian.k@gmail.com',
                    'body' => 'UMKM memang kunci pertumbuhan ekonomi digital. Pendampingan literasi keuangan digital sangat krusial bagi pedagang pasar tradisional.',
                    'created_at' => now()->subDays(1),
                    'replies' => [
                        [
                            'name' => 'Admin NusaKini',
                            'email' => 'redaksi@nusakini.com',
                            'body' => 'Terima kasih atas tanggapannya, Rian. Kami juga berencana meliput inisiatif akar rumput terkait ini.',
                            'created_at' => now()->subHours(20),
                        ]
                    ]
                ],
                [
                    'name' => 'Hendra Wijaya',
                    'email' => 'hendrawijaya@outlook.com',
                    'body' => 'Sangat setuju! Peningkatan 18% omzet nasional itu luar biasa di masa pasca-pandemi.',
                    'created_at' => now()->subHours(10),
                ]
            ],
            'mengintip-masa-depan-ai-medis' => [
                [
                    'name' => 'dr. Anita Safitri',
                    'email' => 'anita.medis@gmail.com',
                    'body' => 'AI sangat membantu dokter dalam skrining radiologi awal. Tetapi tanggung jawab diagnosa akhir tetap di tangan medis profesional. Kombinasi yang hebat!',
                    'created_at' => now()->subHours(12),
                ]
            ],
            'kebangkitan-sport-science-atlet' => [
                [
                    'name' => 'Coach Gunawan',
                    'email' => 'gunawan.coach@pbds.org',
                    'body' => 'Penerapan sport science di Pelatnas sudah mendesak jika kita ingin bersaing dengan negara-negara raksasa seperti China dan Jepang di Olimpiade.',
                    'created_at' => now()->subHours(8),
                ]
            ],
            'seni-menemukan-ketenangan-wellness-travel' => [
                [
                    'name' => 'Wulan Dari',
                    'email' => 'wulandari@live.com',
                    'body' => 'Artikel yang ditulis dengan sangat indah. Wellness travel memang bukan tren belaka, tapi kebutuhan gaya hidup modern yang penuh stres.',
                    'created_at' => now()->subHours(3),
                ]
            ]
        ];

        foreach ($commentsData as $slug => $comments) {
            $article = Article::where('slug', $slug)->first();
            if ($article) {
                foreach ($comments as $commentData) {
                    $comment = Comment::create([
                        'article_id' => $article->id,
                        'name' => $commentData['name'],
                        'email' => $commentData['email'],
                        'body' => $commentData['body'],
                        'created_at' => $commentData['created_at'],
                        'updated_at' => $commentData['created_at'],
                    ]);
                    
                    if (isset($commentData['replies'])) {
                        foreach ($commentData['replies'] as $replyData) {
                            Comment::create([
                                'article_id' => $article->id,
                                'parent_id' => $comment->id,
                                'name' => $replyData['name'],
                                'email' => $replyData['email'],
                                'body' => $replyData['body'],
                                'created_at' => $replyData['created_at'],
                                'updated_at' => $replyData['created_at'],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
