<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '
                    <p class="lead" style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 25px; line-height: 1.8; font-weight: 500;">
                        NusaKini adalah portal media digital independen yang berdedikasi menyajikan jurnalisme investigatif, mendalam, dan bermutu tinggi seputar dinamika politik, ekonomi makro, perkembangan sains medis, dan teknologi masa depan di Indonesia.
                    </p>
                    <p style="margin-bottom: 20px;">
                        Lahir dari komitmen untuk menjaga integritas informasi, NusaKini berusaha keras untuk menyaring riak kebisingan era digital dan memurnikan esensi jurnalisme sejati. Kami berpegang teguh pada prinsip keberimbangan, akurasi data visual yang jernih, serta ulasan mendalam tanpa keberpihakan politik praktis.
                    </p>
                    <div style="margin: 40px 0; padding: 25px; background-color: var(--color-light); border-left: 4px solid var(--color-primary); border-radius: var(--border-radius-sm);">
                        <h4 style="margin-top: 0; margin-bottom: 10px; color: var(--color-dark); font-weight: 800;">Visi Utama Kami</h4>
                        <p style="margin: 0; font-style: italic;">
                            "Menjadi mercusuar jurnalisme data dan analisis investigatif terpercaya yang mencerdaskan publik serta mendorong terciptanya masyarakat Indonesia yang madani, kritis, dan berwawasan luas."
                        </p>
                    </div>
                    <h3 style="margin-top: 35px; margin-bottom: 15px; color: var(--color-dark); font-weight: 800;">Misi NusaKini</h3>
                    <ul style="margin-bottom: 25px; padding-left: 20px; list-style-type: square;">
                        <li style="margin-bottom: 10px;">Menyediakan berita investigasi yang akurat, kredibel, dan tervalidasi berlapis.</li>
                        <li style="margin-bottom: 10px;">Mengedukasi pembaca dengan visualisasi data infografis mutakhir dan infografis sains populer.</li>
                        <li style="margin-bottom: 10px;">Menyediakan wadah opini yang bermutu bagi para cendekiawan, praktisi industri, dan pengambil keputusan.</li>
                        <li style="margin-bottom: 10px;">Menjaga independensi redaksional dari pengaruh kelompok kepentingan politik maupun komersial.</li>
                    </ul>
                ',
                'is_active' => true,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '
                    <p class="lead" style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 25px; line-height: 1.8; font-weight: 500;">
                        Kebijakan Privasi ini menjelaskan bagaimana NusaKini mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan portal berita dan layanan premium kami.
                    </p>
                    <h3 style="margin-top: 35px; margin-bottom: 15px; color: var(--color-dark); font-weight: 800;">1. Data yang Kami Kumpulkan</h3>
                    <p style="margin-bottom: 20px;">
                        Saat Anda berinteraksi dengan portal NusaKini, kami mengumpulkan informasi penting berupa:
                    </p>
                    <ul style="margin-bottom: 25px; padding-left: 20px; list-style-type: disc;">
                        <li style="margin-bottom: 10px;"><strong>Komentar Berita:</strong> Nama, alamat email, dan isi komentar yang Anda ketikkan secara sukarela di halaman detail artikel.</li>
                        <li style="margin-bottom: 10px;"><strong>Bookmark & Simpanan:</strong> Daftar artikel yang Anda tandai disimpan di peramban lokal Anda menggunakan mekanisme <code>localStorage</code>. Data ini sepenuhnya berada di perangkat Anda.</li>
                        <li style="margin-bottom: 10px;"><strong>Newsletter:</strong> Alamat email yang Anda masukkan untuk berlangganan ulasan redaksi mingguan.</li>
                        <li style="margin-bottom: 10px;"><strong>Log Pencarian:</strong> Kata kunci pencarian yang Anda masukkan digunakan secara agregat untuk memantau topik hangat yang disukai audiens kami.</li>
                    </ul>
                    <h3 style="margin-top: 35px; margin-bottom: 15px; color: var(--color-dark); font-weight: 800;">2. Keamanan & Perlindungan Data</h3>
                    <p style="margin-bottom: 20px;">
                        NusaKini menjamin bahwa alamat email dan data pribadi Anda tidak akan pernah dijual, disewakan, atau dibagikan kepada pihak ketiga untuk tujuan komersial atau periklanan luar. Seluruh data disimpan dalam server dengan perlindungan enkripsi standar industri.
                    </p>
                ',
                'is_active' => true,
            ],
            [
                'title' => 'Ketentuan Layanan',
                'slug' => 'ketentuan-layanan',
                'content' => '
                    <p class="lead" style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 25px; line-height: 1.8; font-weight: 500;">
                        Selamat datang di NusaKini. Dengan mengakses dan menggunakan portal ini, Anda menyetujui untuk terikat dan mematuhi seluruh syarat dan ketentuan layanan yang kami tetapkan di bawah ini.
                    </p>
                    <h3 style="margin-top: 35px; margin-bottom: 15px; color: var(--color-dark); font-weight: 800;">1. Hak Cipta & Kekayaan Intelektual</h3>
                    <p style="margin-bottom: 20px;">
                        Seluruh konten tulisan, infografis desain, data visual, laporan video eksklusif, dan logo NusaKini adalah hak milik intelektual NusaKini Editorial Team yang dilindungi oleh undang-undang hak cipta Republik Indonesia. Pengutipan sebagian konten diperbolehkan hanya dengan mencantumkan tautan aktif kembali ke halaman asli NusaKini.
                    </p>
                    <h3 style="margin-top: 35px; margin-bottom: 15px; color: var(--color-dark); font-weight: 800;">2. Panduan Berkomentar Publik</h3>
                    <p style="margin-bottom: 20px;">
                        Kami mendorong diskusi yang kritis, sehat, dan konstruktif di kolom komentar. Namun, NusaKini berhak menghapus komentar yang terbukti mengandung:
                    </p>
                    <ul style="margin-bottom: 25px; padding-left: 20px; list-style-type: circle;">
                        <li style="margin-bottom: 10px;">Unsur SARA, ujaran kebencian, pelecehan seksual, maupun intimidasi personal.</li>
                        <li style="margin-bottom: 10px;">Spam link komersial, promosi barang/jasa ilegal, atau penipuan finansial.</li>
                        <li style="margin-bottom: 10px;">Informasi palsu (hoaks) yang dapat memicu keresahan publik yang luas.</li>
                    </ul>
                ',
                'is_active' => true,
            ],
            [
                'title' => 'Susunan Redaksi',
                'slug' => 'redaksi',
                'content' => '
                    <p class="lead" style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 25px; line-height: 1.8; font-weight: 500;">
                        NusaKini dikelola oleh tim jurnalis profesional, analis data, dan desainer visual yang berdedikasi tinggi menyajikan produk jurnalisme bermutu tinggi demi kepentingan publik.
                    </p>
                    
                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin: 35px 0;">
                        <div style="padding: 20px; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); border-radius: var(--border-radius-sm);">
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase;">Pemimpin Redaksi / Penanggung Jawab</span>
                            <h4 style="margin: 5px 0 0 0; color: var(--color-dark); font-size: 1.15rem; font-weight: 800;">Andika Wijaya, M.A.</h4>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div style="padding: 20px; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); border-radius: var(--border-radius-sm);">
                                <span style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase;">Redaktur Pelaksana</span>
                                <h4 style="margin: 5px 0 0 0; color: var(--color-dark); font-size: 1.1rem; font-weight: 800;">Budi Santoso</h4>
                            </div>
                            <div style="padding: 20px; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); border-radius: var(--border-radius-sm);">
                                <span style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase;">Redaktur Investigasi</span>
                                <h4 style="margin: 5px 0 0 0; color: var(--color-dark); font-size: 1.1rem; font-weight: 800;">Dewi Lestari</h4>
                            </div>
                        </div>
                        
                        <div style="padding: 20px; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); border-radius: var(--border-radius-sm);">
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase;">Tim Jurnalis & Analis Data</span>
                            <p style="margin: 8px 0 0 0; line-height: 1.6; font-weight: 600; color: var(--color-dark);">
                                Citra Kirana • Haryanto • Rian Gunawan • Elvira Rose
                            </p>
                        </div>
                        
                        <div style="padding: 20px; background-color: var(--color-card-bg); border: 1.5px solid var(--color-border); border-radius: var(--border-radius-sm);">
                            <span style="font-size: 0.75rem; font-weight: 800; color: var(--color-primary); text-transform: uppercase;">Desain Visual & Multimedia</span>
                            <p style="margin: 8px 0 0 0; line-height: 1.6; font-weight: 600; color: var(--color-dark);">
                                Faisal Anwar • Guntur Pratama
                            </p>
                        </div>
                    </div>
                ',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'is_active' => $p['is_active'],
                ]
            );
        }
    }
}
