<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all authors from database to link user_id
        $andika = User::where('email', 'andika@nusakini.com')->first();
        $siti = User::where('email', 'siti@nusakini.com')->first();
        $budi = User::where('email', 'budi@nusakini.com')->first();
        $dwi = User::where('email', 'dwi@nusakini.com')->first();
        $laras = User::where('email', 'laras@nusakini.com')->first();

        $articles = [
            [
                'slug' => 'reformasi-regulasi-energi-hijau',
                'title' => 'Reformasi Regulasi Energi Hijau Menuju Indonesia Net-Zero 2060',
                'excerpt' => 'Pemerintah meresmikan paket kebijakan regulasi baru guna mempercepat transisi energi hijau di seluruh provinsi, membuka peluang investasi ramah lingkungan hingga miliaran dolar.',
                'content' => '
                    <p class="drop-cap">Pemerintah Indonesia secara resmi mengumumkan peluncuran paket kebijakan regulasi terpadu yang dirancang khusus untuk mempercepat transisi energi nasional dari fosil ke energi baru terbarukan (EBT). Langkah strategis ini diambil sebagai perwujudan komitmen kuat untuk mencapai target Net-Zero Emission pada tahun 2060 atau lebih cepat.</p>
                    
                    <p>Dalam konferensi pers nasional kemarin, Menteri Energi dan Sumber Daya Mineral menekankan bahwa reformasi regulasi ini tidak hanya mempermudah birokrasi perizinan proyek hijau, tetapi juga memberikan insentif fiskal yang sangat menarik bagi para investor lokal maupun global. Skema tarif pembelian listrik EBT (*feed-in tariff*) kini disesuaikan secara dinamis agar lebih menguntungkan semua pihak.</p>
                    
                    <blockquote>
                        "Transisi energi bukanlah sekadar kewajiban moral terhadap kelestarian bumi, melainkan peluang emas untuk menata ulang struktur ekonomi nasional, menciptakan lapangan kerja hijau baru, dan mandiri secara energi."
                    </blockquote>
                    
                    <h3>Prioritas Utama Sektor Energi Baru Terbarukan</h3>
                    <p>Paket kebijakan yang tertuang dalam Peraturan Presiden terbaru ini mencakup tiga fokus utama pengembangan teknologi hijau di tanah air:</p>
                    <ul>
                        <li><strong>Pembangkit Listrik Tenaga Surya (PLTS) Terapung:</strong> Memaksimalkan area dan permukaan bendungan nasional untuk panel surya skala besar guna menghindari konflik penggunaan lahan produktif.</li>
                        <li><strong>Energi Geotermal (Panas Bumi):</strong> Optimalisasi wilayah cincin api (*Ring of Fire*) nusantara dengan eksplorasi sumur panas bumi baru di wilayah timur Indonesia yang berpotensi menghasilkan ribuan megawatt.</li>
                        <li><strong>Pembangkit Bayu (Angin):</strong> Pembangunan ladang angin pesisir pantai di Sulawesi dan Nusa Tenggara yang memiliki konsistensi hembusan angin tinggi sepanjang tahun.</li>
                    </ul>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?q=80&w=1200" alt="Solar Panels farm" style="border-radius:12px; width:100%;">
                        <figcaption>Ladang panel surya terapung yang dikembangkan di atas bendungan sebagai pilar EBT masa depan. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Tantangan Pembiayaan dan Dukungan Finansial</h3>
                    <p>Meskipun regulasi telah dipermudah, para pakar ekonomi menekankan bahwa tantangan utama transisi energi terletak pada aspek pendanaan awal. Diperkirakan Indonesia membutuhkan dana tak kurang dari 1.000 triliun rupiah dalam tiga dekade mendatang untuk memodernisasi infrastruktur jaringan listrik (*smart grid*) nasional agar mampu menampung suplai listrik yang bersifat fluktuatif (*intermittent*) dari energi bersih.</p>
                    <p>Untuk mengatasi hal tersebut, pemerintah menggandeng konsorsium lembaga pembiayaan internasional serta menerbitkan obligasi hijau (*Green Bond*) di bursa efek internasional. Hal ini diharapkan mampu menekan biaya modal (*cost of capital*) bagi para pengembang proyek EBT swasta di dalam negeri.</p>
                ',
                'category' => 'Politik',
                'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?q=80&w=800',
                'user_id' => $andika->id,
                'read_time' => '5 menit',
                'views' => 1845,
                'is_headline' => true,
                'is_secondary_headline' => false,
                'reactions_suka' => 124,
                'reactions_terkejut' => 28,
                'reactions_inspiratif' => 84,
                'reactions_sedih' => 2,
                'created_at' => Carbon::now()
            ],
            [
                'slug' => 'ekonomi-digital-melaju-pesat',
                'title' => 'Ekonomi Digital Melaju Pesat, Sektor UMKM Jadi Penopang Utama Kuartal I',
                'excerpt' => 'Pertumbuhan sektor ekonomi digital Indonesia tercatat melonjak hingga 18% di kuartal pertama tahun ini, didorong oleh akselerasi adopsi digital oleh pelaku usaha mikro di berbagai daerah.',
                'content' => '
                    <p class="drop-cap">Ekonomi digital Indonesia kembali menunjukkan performa yang luar biasa pada Kuartal I tahun ini. Berdasarkan laporan komprehensif yang dirilis oleh Bank Indonesia, transaksi sektor ekonomi digital terbukti melesat sebesar 18% dibanding periode yang sama di tahun sebelumnya.</p>
                    
                    <p>Pendorong utama dari lonjakan signifikan ini bukanlah korporasi skala raksasa, melainkan puluhan ribu pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) daerah yang secara agresif mulai mengadopsi platform digital. Integrasi sistem pembayaran kode QR nasional (QRIS) serta meluasnya ekosistem e-commerce lokal telah mereduksi hambatan geografis bagi para pedagang tradisional.</p>
                    
                    <blockquote>
                        "Digitalisasi UMKM adalah roda penggerak ekonomi riil sejati. Ketika warung kelontong di desa terpencil dapat menerima pembayaran cashless dan memasarkan produknya secara nasional, saat itulah inklusi keuangan tercapai."
                    </blockquote>
                    
                    <h3>Infrastruktur Jaringan dan Kebijakan QRIS Lintas Negara</h3>
                    <p>Ekspansi pertumbuhan ini juga didukung kuat oleh perluasan infrastruktur internet serat optik nasional serta perluasan jaringan 5G di wilayah luar pulau Jawa. Selain itu, inisiatif integrasi QRIS lintas negara (*cross-border QRIS*) yang kini mencakup Malaysia, Thailand, dan Singapura turut mendongkrak transaksi ekspor dari UMKM kreatif lokal yang sering dikunjungi oleh turis asing.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=1200" alt="Digital payments retail" style="border-radius:12px; width:100%;">
                        <figcaption>Adopsi sistem pembayaran non-tunai di pasar retail menjadi pemicu utama akselerasi ekonomi digital. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Peran Fintech dalam Pembiayaan Produktif</h3>
                    <p>Akses pembiayaan modal kerja yang selama ini menjadi kendala klasik UMKM kini mulai teratasi dengan kehadiran industri teknologi finansial (*fintech lending*) yang kredibel dan berizin resmi. Dengan analisis credit scoring berbasis kecerdasan buatan, pelaku usaha kecil kini dapat memperoleh pinjaman modal produktif tanpa agunan konvensional hanya dalam waktu hitungan jam saja.</p>
                ',
                'category' => 'Ekonomi',
                'image' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=800',
                'user_id' => $siti->id,
                'read_time' => '4 menit',
                'views' => 1420,
                'is_headline' => false,
                'is_secondary_headline' => true,
                'reactions_suka' => 98,
                'reactions_terkejut' => 5,
                'reactions_inspiratif' => 67,
                'reactions_sedih' => 0,
                'created_at' => Carbon::now()->subHours(4)
            ],
            [
                'slug' => 'mengintip-masa-depan-ai-medis',
                'title' => 'Mengintip Masa Depan Kecerdasan Buatan (AI) dalam Dunia Medis Modern',
                'excerpt' => 'Implementasi sistem diagnosis berbasis kecerdasan buatan terbukti mempercepat deteksi dini kanker paru hingga 90% akurasi, menandai babak baru revolusi kedokteran.',
                'content' => '
                    <p class="drop-cap">Teknologi kecerdasan buatan (*Artificial Intelligence*) kini tidak lagi sebatas tren asisten penulisan teks atau penjawab otomatis. Di lini terdepan sains kesehatan, AI sedang bertransformasi menjadi mitra paling krusial bagi para dokter spesialis untuk mendiagnosis penyakit kritis sejak fase awal.</p>
                    
                    <p>Rumah sakit rujukan nasional bekerjasama dengan lembaga riset teknologi baru saja meluncurkan uji klinis penggunaan algoritma pemelajaran mendalam (*deep learning*) yang dilatih pada jutaan citra pemindaian medis. Hasilnya luar biasa: sistem AI mampu mengidentifikasi anomali sel kanker paru-paru stadium mikro dengan tingkat akurasi mencapai 90%, jauh melebihi rata-rata diagnosis visual konvensional.</p>
                    
                    <blockquote>
                        "AI tidak akan menggantikan peran dokter di rumah sakit, melainkan mendampingi dan memperkuat kemampuan analisis mereka. Kolaborasi antara kepekaan kemanusiaan dokter dengan presisi komputasi AI adalah masa depan kedokteran."
                    </blockquote>
                    
                    <h3>Kecepatan Analisis Data Genomik</h3>
                    <p>Selain diagnosis pemindaian organ, AI juga dimanfaatkan untuk memetakan rangkaian genomik (*genomic sequencing*) pasien dalam hitungan menit saja. Hal ini membuka jalan bagi terapi kedokteran personal (*personalized medicine*), di mana obat-obatan dan porsi perawatan dirancang secara spesifik berdasarkan profil genetik unik masing-masing individu untuk menekan risiko efek samping obat.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1200" alt="Doctor looking at digital scan" style="border-radius:12px; width:100%;">
                        <figcaption>Teknologi diagnosis medis terbantu AI mempercepat pengambilan keputusan krusial di ruang operasi. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Isu Etika dan Keamanan Data Pasien</h3>
                    <p>Kendati menawarkan revolusi luar biasa, kemajuan ini menyisakan diskusi mendalam seputar aspek etika serta kerahasiaan data rekam medis pasien. Komisi Kedokteran Nasional terus merumuskan batas-batas kepatuhan regulasi yang ketat agar pemanfaatan data pelatihan medis terjamin anonimitasnya dan bebas dari risiko kebocoran data siber.</p>
                ',
                'category' => 'Teknologi',
                'image' => 'https://images.unsplash.com/photo-1507146426996-ef05306b995a?q=80&w=800',
                'user_id' => $budi->id,
                'read_time' => '6 menit',
                'views' => 2130,
                'is_headline' => false,
                'is_secondary_headline' => true,
                'reactions_suka' => 205,
                'reactions_terkejut' => 45,
                'reactions_inspiratif' => 198,
                'reactions_sedih' => 1,
                'created_at' => Carbon::now()->subHours(8)
            ],
            [
                'slug' => 'kebangkitan-sport-science-atlet',
                'title' => 'Kebangkitan Sport Science pada Persiapan Atlet Nasional Menuju Olimpiade',
                'excerpt' => 'Komite Olimpiade menerapkan metodologi sport science termutakhir untuk menganalisis beban latihan fisik, biomekanika gerak, hingga nutrisi personal guna mendongkrak performa atlet.',
                'content' => '
                    <p class="drop-cap">Menjelang gelaran Olimpiade mendatang, komite pembinaan prestasi olahraga nasional mengambil langkah revolusioner dengan mengadopsi ilmu keolahragaan modern (*sport science*) secara menyeluruh dalam pemusatan latihan nasional (Pelatnas).</p>
                    
                    <p>Langkah ini menandai berakhirnya era latihan fisik monoton konvensional yang kerap memicu cedera otot kronis. Melalui pemasangan sensor biomekanika nirkabel di sekujur tubuh atlet saat berlatih, tim pelatih kini dapat memetakan efisiensi gerak anatomis serta mendeteksi titik lelah otot dengan presisi tinggi melalui grafik komputer real-time.</p>
                    
                    <blockquote>
                        "Di level tertinggi olahraga internasional, perbedaan antara medali emas dan kegagalan seringkali hanya terpaut perseratus detik. Sport science memberi kami detail presisi yang dibutuhkan untuk memenangkan persaingan mikro tersebut."
                    </blockquote>
                    
                    <h3>Analisis Nutrisi Personal Berbasis Metabolisme</h3>
                    <p>Aspek nutrisi juga tidak luput dari pembaruan metodologi sains. Setiap atlet kini memiliki koki gizi personal yang merancang diet harian berdasarkan analisis laju metabolisme, kadar asam laktat darah pasca-latihan, hingga pola tidur (*sleep tracking*) mereka. Hal ini memastikan proses pemulihan fisik (*recovery*) berjalan maksimal sebelum sesi latihan berikutnya.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1200" alt="Athlete training" style="border-radius:12px; width:100%;">
                        <figcaption>Peralatan latihan berteknologi tinggi mengukur kapasitas kardiovaskular atlet Pelatnas. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Dukungan Psikologi Olahraga</h3>
                    <p>Selain optimalisasi fisik, sport science juga mencakup aspek kekuatan mental (*sports psychology*). Latihan simulasi konsentrasi menggunakan sistem realitas virtual (VR) diterapkan untuk membiasakan atlet menghadapi tekanan psikologis kebisingan penonton stadion, melatih fokus pengambilan keputusan krusial di momen genting pertandingan.</p>
                ',
                'category' => 'Olahraga',
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=800',
                'user_id' => $dwi->id,
                'read_time' => '5 menit',
                'views' => 1105,
                'is_headline' => false,
                'is_secondary_headline' => true,
                'reactions_suka' => 84,
                'reactions_terkejut' => 2,
                'reactions_inspiratif' => 45,
                'reactions_sedih' => 0,
                'created_at' => Carbon::now()->subHours(12)
            ],
            [
                'slug' => 'seni-menemukan-ketenangan-wellness-travel',
                'title' => 'Seni Menemukan Ketenangan: Tren Wellness Travel di Destinasi Tersembunyi Indonesia',
                'excerpt' => 'Wisata kebugaran spiritual dan pemulihan jiwa (*wellness travel*) makin digandrungi kalangan profesional urban, memicu kebangkitan resort-resort retret ekologis terpencil.',
                'content' => '
                    <p class="drop-cap">Tekanan pekerjaan yang tinggi serta hiruk-pikuk kehidupan kota besar telah menggeser preferensi liburan masyarakat kelas menengah urban. Destinasi belanja mewah atau taman hiburan padat mulai digantikan oleh tren liburan kebugaran jiwa (*wellness travel*) yang menekankan pada pemulihan fisik dan kedamaian batin.</p>
                    
                    <p>Wisatawan kini rela bepergian ke pelosok kepulauan Indonesia—mulai dari perbukitan sunyi di Ubud, Bali, hingga pantai terisolasi di Sumba—untuk mengikuti program retret yoga, meditasi keheningan (*silent retreat*), terapi detoksifikasi digital, hingga sesi spa herbal tradisional berbasis tanaman obat lokal.</p>
                    
                    <blockquote>
                        "Wellness travel bukan sekadar tren liburan melainkan gerakan kesadaran hidup. Ini adalah momen menghentikan sejenak perlombaan hidup demi menyelaraskan ritme tubuh dengan frekuensi alam yang murni."
                    </blockquote>
                    
                    <h3>Resort Retret Ekologis Ramah Lingkungan</h3>
                    <p>Tumbuhnya tren ini mendorong lahirnya resort-resort butik baru berkonsep arsitektur bambu ramah lingkungan (*eco-resort*). Menariknya, tempat-tempat ini menerapkan aturan ketat seperti ketiadaan televisi di dalam kamar, pembatasan koneksi internet pada jam tertentu, serta penyajian menu makanan organik vegan (*farm-to-table*) yang bahan bakunya langsung dipanen dari kebun warga lokal di sekitar resort.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1545205597-3d9d02c29597?q=80&w=1200" alt="Yoga mediation at resort" style="border-radius:12px; width:100%;">
                        <figcaption>Retret yoga luar ruangan di perbukitan Ubud yang menawarkan ketenangan batin mutlak. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Kontribusi bagi Perekonomian Warga Lokal</h3>
                    <p>Aspek terpenting dari wisata kebugaran ini adalah keterlibatan langsung masyarakat adat. Resort mengajak para pemuka spiritual lokal untuk memimpin upacara pembersihan diri tradisional (*melukat*), mempekerjakan ahli pengobatan herbal daerah, serta membeli bahan pangan lokal. Pola kemitraan ini terbukti menjaga kelestarian budaya sekaligus mendongkrak kesejahteraan ekonomi warga desa secara langsung.</p>
                ',
                'category' => 'Gaya Hidup',
                'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=800',
                'user_id' => $laras->id,
                'read_time' => '4 menit',
                'views' => 1560,
                'is_headline' => false,
                'is_secondary_headline' => false,
                'reactions_suka' => 143,
                'reactions_terkejut' => 15,
                'reactions_inspiratif' => 112,
                'reactions_sedih' => 1,
                'created_at' => Carbon::now()->subDays(1)
            ],
            [
                'slug' => 'ktt-iklim-global-sepakati-pendanaan',
                'title' => 'KTT Iklim Global Sepakati Pendanaan Transisi Energi Negara Berkembang',
                'excerpt' => 'Pertemuan KTT Iklim PBB menyepakati komitmen bersejarah dana kompensasi 150 miliar dolar dari negara maju untuk membantu mitigasi dampak perubahan iklim di Asia dan Afrika.',
                'content' => '
                    <p class="drop-cap">Babak baru aksi penanganan darurat perubahan iklim global resmi dimulai. Konferensi Tingkat Tinggi (KTT) Iklim PBB yang berlangsung alot selama dua pekan akhirnya ditutup dengan kesepakatan konsensus bersejarah yang mengikat secara hukum bagi seluruh negara anggota.</p>
                    
                    <p>Negara-negara industri maju secara mengejutkan menyetujui komitmen pembentukan dana kompensasi khusus senilai 150 miliar dolar AS per tahun. Dana tersebut ditargetkan sepenuhnya untuk membiayai infrastruktur mitigasi iklim, program perlindungan pesisir pantai dari kenaikan air laut, serta subsidi transisi energi hijau di negara-negara berkembang lintas benua Asia dan Afrika.</p>
                    
                    <blockquote>
                        "Kesepakatan ini adalah kemenangan bagi keadilan iklim global. Negara-negara berkembang yang menderita dampak terberat dari pemanasan global kini memiliki sokongan finansial riil untuk memitigasi bencana ini."
                    </blockquote>
                    
                    <h3>Komitmen Penghentian Bertahap Pembangkit Batubara</h3>
                    <p>Sebagai timbal balik dari aliran dana hibah hijau tersebut, negara berkembang berkomitmen untuk mempercepat target penutupan pembangkit listrik tenaga uap (PLTU) batubara dalam satu dekade mendatang. Delegasi Indonesia menyambut baik skema ini dan menyebutnya akan melipatgandakan program pensiun dini PLTU batubara nasional yang sedang dikerjakan.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1618042164219-62c820f10723?q=80&w=1200" alt="Wind turbines at sunset" style="border-radius:12px; width:100%;">
                        <figcaption>Jaringan kincir angin lepas pantai yang akan masif dikembangkan berkat kucuran dana KTT Iklim Global. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Sanksi Ketat bagi Pelanggar Kuota Emisi Carbon</h3>
                    <p>KTT kali ini juga menyepakati pembentukan badan pengawas iklim independen PBB yang berhak menjatuhkan sanksi hambatan perdagangan internasional bagi negara industri yang terbukti melanggar batas kuota pelepasan emisi karbon tahunan mereka. Langkah penegakan sanksi ini diyakini akan mendesak industri manufaktur global untuk segera memodernisasi pabrik mereka menjadi netral karbon.</p>
                ',
                'category' => 'Internasional',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800',
                'user_id' => $andika->id,
                'read_time' => '5 menit',
                'views' => 1970,
                'is_headline' => false,
                'is_secondary_headline' => false,
                'reactions_suka' => 156,
                'reactions_terkejut' => 31,
                'reactions_inspiratif' => 97,
                'reactions_sedih' => 4,
                'created_at' => Carbon::now()->subDays(2)
            ],
            [
                'slug' => 'evolusi-jaringan-6g-iot',
                'title' => 'Evolusi Jaringan 6G: Kecepatan Data Tanpa Batas dan Era IoT Terkoneksi Penuh',
                'excerpt' => 'Riset awal jaringan telekomunikasi generasi keenam (6G) sukses melampaui latensi mikro-detik, menjanjikan era mobil otonom dan operasi bedah jarak jauh tanpa hambatan.',
                'content' => '
                    <p class="drop-cap">Ketika sebagian wilayah dunia masih beradaptasi dengan penyebaran infrastruktur 5G, konsorsium telekomunikasi dan sains global telah melangkah jauh dengan mencatatkan rekor transmisi data perdana pada jaringan 6G.</p>
                    
                    <p>Uji laboratorium gabungan berhasil meraih latensi di bawah mikro-detik dengan kecepatan unduh nirkabel yang menyentuh angka 1 Terabit per detik. Kecepatan fantastis ini diklaim 100 kali lipat melampaui kemampuan maksimal jaringan 5G komersial saat ini, membuka pintu bagi ekosistem Internet of Things (IoT) yang terkoneksi tanpa hambatan fisik.</p>
                    
                    <blockquote>
                        "Jaringan 6G bukan sekadar peningkatan kecepatan internet gawai, melainkan fondasi bagi integrasi cyber-physical. Era di mana kecerdasan buatan terdistribusi menyatu langsung dengan infrastruktur kota cerdas dan robotika otonom."
                    </blockquote>
                    
                    <h3>Bedah Jarak Jauh dan Mobil Otonom Tanpa Sopir</h3>
                    <p>Latensi nol mutlak yang ditawarkan 6G memiliki signifikansi luar biasa pada sektor penyelamatan jiwa. Para dokter bedah spesialis akan dapat mengoperasikan lengan robot medis secara real-time dari jarak ribuan kilometer tanpa khawatir adanya jeda transmisi (*delay*). Hal serupa juga menjamin keamanan penuh bagi koordinasi jutaan mobil otonom tanpa pengemudi di jalan raya perkotaan secara simultan.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1200" alt="Tech engineer at network servers" style="border-radius:12px; width:100%;">
                        <figcaption>Laboratorium pengujian transmisi frekuensi tinggi untuk riset pemancaran sinyal telekomunikasi 6G. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Tantangan Pemancaran Frekuensi Terahertz</h3>
                    <p>Kendati demikian, tantangan fisik pengembangan 6G terletak pada transmisi gelombang frekuensi sangat tinggi (Terahertz). Gelombang ini memiliki kelemahan jarak pancar yang sangat pendek serta mudah terhalang oleh material padat seperti dinding gedung beton. Para peneliti terus menguji material baru antena berbasis nanoteknologi guna memperluas pancaran sinyal di area urban.</p>
                ',
                'category' => 'Teknologi',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800',
                'user_id' => $budi->id,
                'read_time' => '5 menit',
                'views' => 1780,
                'is_headline' => false,
                'is_secondary_headline' => false,
                'reactions_suka' => 189,
                'reactions_terkejut' => 52,
                'reactions_inspiratif' => 143,
                'reactions_sedih' => 0,
                'created_at' => Carbon::now()->subDays(3)
            ],
            [
                'slug' => 'investasi-infrastruktur-transportasi-massal',
                'title' => 'Investasi Infrastruktur Transportasi Massal Menjadi Fokus APBN Dekade Ini',
                'excerpt' => 'Kementerian Keuangan merencanakan porsi besar belanja modal APBN dialokasikan untuk pembangunan jaringan kereta cepat dan integrasi moda transportasi perkotaan di luar Jawa.',
                'content' => '
                    <p class="drop-cap">Pemerintah menegaskan arah belanja modal Anggaran Pendapatan dan Belanja Negara (APBN) untuk dekade ini akan menitikberatkan pada percepatan konektivitas transportasi publik massal bebas macet, demi mengurangi ketergantungan pada BBM subsidi.</p>
                    
                    <p>Rencana strategis ini menitikberatkan pembangunan rel kereta api cepat lintas provinsi di pulau Sumatra, Kalimantan, serta integrasi jaringan Light Rail Transit (LRT) modern di kota-kota besar metropolitan luar Jawa seperti Medan, Makassar, dan Balikpapan yang kini mulai menghadapi ancaman kemacetan lalu lintas parah.</p>
                    
                    <blockquote>
                        "Membangun jalan tol hanya memindahkan kemacetan ke masa depan. Membangun transportasi massal terintegrasi dan nyaman adalah solusi permanen untuk efisiensi mobilitas energi dan menurunkan tingkat polusi udara perkotaan."
                    </blockquote>
                    
                    <h3>Penghematan Subsidi Bahan Bakar Minyak</h3>
                    <p>Kementerian Keuangan menghitung bahwa setiap perpindahan 10% pengguna kendaraan pribadi ke moda transportasi massal berbasis listrik akan menghemat dana subsidi energi BBM negara hingga puluhan triliun rupiah per tahun. Dana hasil efisiensi ini nantinya akan dialihkan langsung untuk peningkatan anggaran pendidikan vokasi serta fasilitas kesehatan masyarakat miskin.</p>
                    
                    <figure>
                        <img src="https://images.unsplash.com/photo-1474487548417-781cb71495f3?q=80&w=1200" alt="Mass transit trains" style="border-radius:12px; width:100%;">
                        <figcaption>Jaringan kereta cepat komuter perkotaan ramah lingkungan sebagai masa depan mobilitas masyarakat urban. (Foto: Unsplash)</figcaption>
                    </figure>

                    <h3>Kerjasama Pendanaan Swasta Lewat Skema KPBU</h3>
                    <p>Mengingat anggaran pembangunan yang sangat fantastis, proyek transportasi massal ini tidak hanya mengandalkan suntikan dana kas negara murni. Pemerintah masif menerapkan skema Kerjasama Pemerintah dan Badan Usaha (KPBU) guna menarik minat investasi dana pensiun asing jangka panjang untuk ikut berpartisipasi mengelola stasiun modern berkonsep TOD (*Transit Oriented Development*).</p>
                ',
                'category' => 'Ekonomi',
                'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?q=80&w=800',
                'user_id' => $siti->id,
                'read_time' => '5 menit',
                'views' => 1250,
                'is_headline' => false,
                'is_secondary_headline' => false,
                'reactions_suka' => 88,
                'reactions_terkejut' => 4,
                'reactions_inspiratif' => 53,
                'reactions_sedih' => 0,
                'created_at' => Carbon::now()->subDays(4)
            ],
            [
                'slug' => 'kebangkitan-badminton-junior',
                'title' => 'Lahirnya Generasi Baru: Dominasi Pebulutangkis Junior di Turnamen Internasional',
                'excerpt' => 'Skuad badminton junior Indonesia menyapu bersih 4 medali emas di kejuaraan asia, membuktikan regenerasi atlet nasional berjalan sangat gemilang.',
                'content' => '
                    <p class="drop-cap">Prestasi membanggakan kembali diukir oleh bibit-bibit muda bulutangkis Indonesia. Berkompetisi di Kejuaraan Asia Junior kemarin, tim Merah Putih sukses menyapu bersih empat medali emas dari sektor tunggal putra, ganda putra, ganda putri, dan ganda campuran.</p>
                    
                    <p>Kemenangan mutlak ini menjadi angin segar di tengah sorotan publik atas penurunan performa atlet senior di beberapa turnamen dunia sebelumnya. Kepala Bidang Pembinaan Prestasi menegaskan bahwa restrukturisasi sistem rekrutmen berbasis pemetaan genetik dan sensor gerak terbukti berhasil menjaring talenta emas sejak usia dini.</p>
                ',
                'category' => 'Olahraga',
                'image' => 'https://images.unsplash.com/photo-1521537634199-67398c740cc9?q=80&w=800',
                'user_id' => $dwi->id,
                'read_time' => '3 menit',
                'views' => 930,
                'is_headline' => false,
                'is_secondary_headline' => false,
                'reactions_suka' => 70,
                'reactions_terkejut' => 1,
                'reactions_inspiratif' => 38,
                'reactions_sedih' => 0,
                'created_at' => Carbon::now()->subDays(5)
            ]
        ];

        foreach ($articles as $art) {
            Article::updateOrCreate(
                ['slug' => $art['slug']],
                [
                    'user_id' => $art['user_id'],
                    'title' => $art['title'],
                    'excerpt' => $art['excerpt'],
                    'content' => $art['content'],
                    'category' => $art['category'],
                    'image' => $art['image'],
                    'read_time' => $art['read_time'],
                    'views' => $art['views'],
                    'is_headline' => $art['is_headline'],
                    'is_secondary_headline' => $art['is_secondary_headline'],
                    'reactions_suka' => $art['reactions_suka'],
                    'reactions_terkejut' => $art['reactions_terkejut'],
                    'reactions_inspiratif' => $art['reactions_inspiratif'],
                    'reactions_sedih' => $art['reactions_sedih'],
                    'created_at' => $art['created_at'],
                    'updated_at' => $art['created_at']
                ]
            );
        }
    }
}
