<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $member = User::create([
            'role'              => 'member',
            'name'              => 'Min Paimin',
            'email'             => 'minpaimin@gmail.com',
            'telephone'         => '081234567890',
            'password'          => Hash::make('password'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        $staff = User::create([
            'role'              => 'staff',
            'name'              => 'Nem Painem',
            'email'             => 'nempainem@gmail.com',
            'telephone'         => '081234567891',
            'password'          => Hash::make('password'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        $superAdmin = User::create([
            'role'              => 'super_admin',
            'name'              => 'Met Slamet',
            'email'             => 'metslamet@gmail.com',
            'telephone'         => '081234567894',
            'password'          => Hash::make('password'),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        $posts = [
            [
                'date' => Carbon::create(2026, 4, 5),
                'title' => 'Kolaborasi Komunitas Dorong Inovasi Digital Lokal',
                'slug' => 'kolaborasi-komunitas-dorong-inovasi-digital-lokal',
                'description' => 'Sinergi antar anggota komunitas terbukti menjadi kunci lahirnya berbagai solusi digital yang relevan dengan kebutuhan masyarakat lokal. Temukan kisah inspiratif di balik proyek-proyek kolaboratif yang mengubah ekosistem digital daerah.',
                'content' => '<p>Kolaborasi antar anggota komunitas kini menjadi motor penggerak utama inovasi digital di tingkat lokal. Berbagai proyek yang lahir dari diskusi sederhana di komunitas telah berkembang menjadi solusi nyata yang dirasakan manfaatnya oleh masyarakat sekitar.</p><p>Mulai dari aplikasi manajemen UMKM, platform edukasi daring, hingga sistem informasi desa berbasis web — semuanya lahir dari semangat gotong royong digital. Para anggota komunitas saling melengkapi kemampuan, dari desainer, developer, hingga marketer, untuk mewujudkan ide menjadi produk yang berdampak.</p><p>Ekosistem digital daerah pun semakin berkembang seiring meningkatnya kepercayaan diri komunitas lokal dalam berinovasi. Dengan dukungan sesama anggota dan mentor berpengalaman, hambatan teknis maupun non-teknis dapat diatasi bersama.</p>',
            ],
            [
                'date' => Carbon::create(2026, 4, 4),
                'title' => 'Generasi Muda Semakin Aktif dalam Kegiatan Sosial',
                'slug' => 'generasi-muda-semakin-aktif-dalam-kegiatan-sosial',
                'description' => 'Tren keterlibatan anak muda dalam berbagai gerakan sosial terus meningkat. Dari kegiatan lingkungan hingga pemberdayaan masyarakat, generasi Z dan milenial membuktikan bahwa perubahan bisa dimulai dari aksi nyata.',
                'content' => '<p>Keterlibatan generasi muda dalam kegiatan sosial terus menunjukkan tren yang menggembirakan. Generasi Z dan milenial tidak lagi hanya menjadi penonton, tetapi menjadi penggerak perubahan di berbagai bidang, mulai dari lingkungan hidup, pendidikan, hingga pemberdayaan ekonomi masyarakat.</p><p>Berbagai komunitas sosial yang digagas anak muda kini hadir dengan pendekatan yang lebih segar dan relevan. Memanfaatkan media sosial sebagai alat penggerak massa, mereka berhasil menarik ribuan relawan dalam waktu singkat untuk turun langsung ke lapangan.</p><p>Para ahli sosial menilai fenomena ini sebagai sinyal positif bagi masa depan bangsa. Ketika kepedulian sosial tumbuh di kalangan muda, fondasi masyarakat yang kuat dan saling mendukung akan semakin kokoh dibangun dari bawah.</p>',
            ],
            [
                'date' => Carbon::create(2026, 4, 1),
                'title' => 'Workshop Pengembangan Diri Diminati Banyak Peserta',
                'slug' => 'workshop-pengembangan-diri-diminati-banyak-peserta',
                'description' => 'Antusiasme masyarakat terhadap kegiatan pelatihan dan pengembangan diri semakin tinggi. Workshop yang mengangkat tema produktivitas, mindset, dan keterampilan hidup ini berhasil menarik ratusan peserta dari berbagai latar belakang.',
                'content' => '<p>Minat masyarakat terhadap workshop pengembangan diri terus melonjak dalam beberapa tahun terakhir. Sesi-sesi yang membahas produktivitas, growth mindset, manajemen waktu, dan keterampilan interpersonal berhasil menyedot perhatian ratusan peserta dari berbagai profesi dan usia.</p><p>Para fasilitator mencatat bahwa peserta kini datang dengan kebutuhan yang lebih spesifik dan kesadaran diri yang lebih tinggi. Mereka tidak hanya ingin belajar teori, tetapi juga menginginkan panduan praktis yang langsung bisa diterapkan dalam kehidupan sehari-hari.</p><p>Keberhasilan workshop ini mendorong komunitas untuk menjadwalkan lebih banyak sesi serupa secara rutin, dengan topik yang terus diperbarui sesuai kebutuhan peserta. Antusiasme yang tinggi ini membuktikan bahwa investasi pada diri sendiri menjadi prioritas bagi banyak orang.</p>',
            ],
            [
                'date' => Carbon::create(2026, 3, 23),
                'title' => 'Komunitas Lokal Gelar Event Kreatif Tahunan',
                'slug' => 'komunitas-lokal-gelar-event-kreatif-tahunan',
                'description' => 'Ajang tahunan yang dinantikan kembali hadir, menghadirkan ruang ekspresi bagi para seniman, pelaku budaya, dan kreator lokal. Event ini menjadi bukti nyata bahwa kreativitas komunitas mampu menyatukan banyak pihak.',
                'content' => '<p>Event kreatif tahunan yang paling ditunggu-tunggu kembali digelar dengan meriah. Tahun ini, panitia menghadirkan konsep yang lebih inklusif, membuka ruang seluas-luasnya bagi seniman, musisi, penulis, dan kreator konten lokal untuk unjuk karya di hadapan publik.</p><p>Lebih dari lima puluh komunitas berpartisipasi dalam event ini, mengisi berbagai booth pameran, panggung pertunjukan, dan sesi diskusi interaktif. Pengunjung yang hadir tidak hanya bisa menikmati karya, tetapi juga berinteraksi langsung dengan para kreatornya.</p><p>Event ini sekali lagi membuktikan bahwa komunitas lokal memiliki kekayaan kreativitas yang tidak kalah dengan kota-kota besar. Dengan dukungan semua pihak, ajang ini diharapkan terus tumbuh dan menjadi kebanggaan daerah setiap tahunnya.</p>',
            ],
            [
                'date' => Carbon::create(2026, 3, 22),
                'title' => 'Pentingnya Jejaring dalam Dunia Profesional Modern',
                'slug' => 'pentingnya-jejaring-dalam-dunia-profesional-modern',
                'description' => 'Di era kompetisi global, membangun relasi yang kuat bukan lagi sekadar pilihan—melainkan keharusan. Artikel ini mengulas strategi efektif membangun jejaring profesional yang bermakna dan berkelanjutan.',
                'content' => '<p>Di tengah persaingan global yang semakin ketat, kemampuan membangun jejaring profesional menjadi salah satu aset paling berharga yang dimiliki seseorang. Bukan sekadar mengumpulkan kontak, networking yang efektif adalah tentang membangun hubungan yang saling menguntungkan dan berkelanjutan.</p><p>Para profesional sukses umumnya menyepakati satu hal: peluang terbaik sering kali datang bukan dari lamaran kerja formal, melainkan dari rekomendasi dan kepercayaan yang dibangun melalui relasi. Oleh karena itu, investasi waktu untuk hadir di komunitas, seminar, dan event profesional menjadi sangat krusial.</p><p>Strategi membangun jejaring yang efektif mencakup konsistensi dalam berkontribusi, kejujuran dalam berkomunikasi, dan kesediaan untuk memberi sebelum meminta. Dengan pendekatan yang tulus dan terarah, jejaring profesional yang kuat bisa menjadi fondasi karier yang kokoh dan peluang bisnis yang tak terbatas.</p>',
            ],
            [
                'date' => Carbon::create(2026, 2, 28),
                'title' => 'Komunitas Gelar Workshop Digital Untuk Pemula',
                'slug' => 'komunitas-gelar-workshop-digital-untuk-pemula',
                'description' => 'Tidak perlu latar belakang teknis untuk mulai belajar dunia digital. Workshop ramah pemula ini dirancang khusus untuk memperkenalkan keterampilan digital dasar kepada masyarakat yang ingin meningkatkan kompetensinya.',
                'content' => '<p>Komunitas kembali mengambil peran aktif dalam meningkatkan literasi digital masyarakat melalui workshop khusus pemula. Tanpa syarat latar belakang teknis, siapa pun bisa bergabung dan mulai belajar keterampilan digital yang relevan dengan kebutuhan zaman.</p><p>Materi yang disajikan mencakup pengenalan internet dan media sosial secara produktif, dasar-dasar penggunaan aplikasi perkantoran, hingga keamanan digital dalam kehidupan sehari-hari. Metode pengajaran yang santai dan interaktif membuat peserta merasa nyaman meski baru pertama kali bersentuhan dengan dunia digital.</p><p>Inisiatif ini mendapat sambutan hangat dari berbagai kalangan, termasuk ibu rumah tangga, pelaku UMKM, hingga lansia yang ingin melek teknologi. Komunitas berkomitmen untuk terus mengadakan workshop serupa secara berkala agar manfaatnya dapat dirasakan oleh lebih banyak orang.</p>',
            ],
            [
                'date' => Carbon::create(2026, 1, 1),
                'title' => 'Seminar Nasional Buka Wawasan Tentang Tren Teknologi Terkini',
                'slug' => 'seminar-nasional-buka-wawasan-tentang-tren-teknologi-terkini',
                'description' => 'Para pakar dan praktisi teknologi berkumpul dalam seminar nasional untuk berbagi pandangan tentang perkembangan AI, otomasi, dan transformasi digital. Wawasan baru siap membuka perspektif Anda tentang masa depan teknologi.',
                'content' => '<p>Seminar nasional bertajuk teknologi masa depan sukses menghadirkan deretan pakar dan praktisi terkemuka dari berbagai bidang. Mereka berbagi pandangan dan analisis mendalam mengenai perkembangan kecerdasan buatan, otomasi industri, dan transformasi digital yang sedang mengubah wajah dunia.</p><p>Salah satu sesi yang paling banyak menarik perhatian adalah diskusi tentang dampak AI terhadap dunia kerja. Para narasumber sepakat bahwa adaptasi dan peningkatan keterampilan adalah kunci agar manusia tetap relevan di era otomasi yang terus berkembang pesat.</p><p>Peserta pulang dengan wawasan baru dan perspektif yang lebih luas tentang arah perkembangan teknologi global. Seminar ini menegaskan pentingnya komunitas untuk terus belajar, berdiskusi, dan bersiap menghadapi berbagai perubahan yang akan datang dalam waktu dekat.</p>',
            ],
            [
                'date' => Carbon::create(2025, 11, 13),
                'title' => 'Event Kolaborasi Hadirkan Berbagai Kegiatan Inspiratif',
                'slug' => 'event-kolaborasi-hadirkan-berbagai-kegiatan-inspiratif',
                'description' => 'Dalam satu panggung yang sama, puluhan komunitas bersatu untuk menghadirkan rangkaian kegiatan yang memotivasi dan menginspirasi. Dari talk show hingga pameran karya, setiap sudut event ini menyimpan cerita yang layak untuk diikuti.',
                'content' => '<p>Puluhan komunitas dari berbagai latar belakang bersatu dalam sebuah event kolaborasi besar yang memadukan edukasi, hiburan, dan inspirasi dalam satu atap. Setiap komunitas membawa keunikannya masing-masing, menciptakan pengalaman yang kaya dan beragam bagi setiap pengunjung yang hadir.</p><p>Rangkaian acara meliputi talk show bersama tokoh-tokoh inspiratif, sesi mentoring interaktif, pameran karya seni dan produk lokal, hingga pertunjukan budaya yang memukau. Setiap sudut venue dirancang untuk mengundang rasa ingin tahu dan mendorong pengunjung untuk terus menjelajah.</p><p>Event ini bukan sekadar perayaan, melainkan juga ruang pertemuan ide dan semangat dari berbagai komunitas yang selama ini berjalan sendiri-sendiri. Kolaborasi yang terjalin diharapkan berlanjut jauh setelah event usai, melahirkan sinergi-sinergi baru yang membawa dampak positif bagi masyarakat luas.</p>',
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'author_id'     => $staff->id,
                'title'         => $post['title'],
                'slug'          => $post['slug'],
                'description'   => $post['description'],
                'content'       => $post['content'],
                'created_at'    => $post['date'],
                'updated_at'    => $post['date'],
            ]);
        }

        $settings = [
            'community_name'        => 'Aplikasi Member Komunitas',
            'community_logo'        => Storage::putFile('uploads', new File(public_path('images/community-logo.png'))),
            'email'                 => 'amk@mail.com',
            'phone_number'          => '081200000000',
            'address'               => 'Gedung Cipta Karya, Jl. Pahlawan Sejahtera No. 5, Surabaya',
            'x_account_url'         => 'https://x.com/amk',
            'facebook_account_url'  => 'https://facebook.com/amk',
            'linkedin_account_url'  => 'https://linkedin.com/amk',
            'skype_account_url'     => 'https://skype.com/amk',
            'instagram_account_url' => 'https://instagram.com/amk',
            'youtube_account_url'   => 'https://youtube.com/amk',
            'account_holder_name'   => 'AMK',
            'account_number'        => '000000001111',
            'bank_name'             => 'Bank BRI',
            'membership_fee'        => '50000',
            'membership_duration'   => '12',
            'invoice_countdown'     => '24',
            'primary_color'         => '#007FFF',
            'surface_color'         => '#E5F2FF',
            'background_image'      => Storage::putFile('uploads', new File(public_path('images/background.jpg'))),
            'hero_title'            => 'Bangun Koneksi dan Tumbuh Bersama',
            'hero_description'      => 'Terhubung dengan individu dari berbagai latar belakang, berbagi ide, dan membangun kolaborasi dalam komunitas inklusif untuk berkembang bersama serta menciptakan dampak nyata.',
            'about_image'           => Storage::putFile('uploads', new File(public_path('images/about.jpg'))),
            'about_title'           => 'Tentang',
            'about_description'     => "Komunitas ini adalah ruang terbuka bagi siapa saja yang ingin belajar, berkembang, dan saling terhubung dalam lingkungan yang positif dan kolaboratif. Kami menghadirkan berbagai kesempatan untuk bertukar wawasan, membangun relasi, serta berpartisipasi dalam kegiatan yang mendorong pertumbuhan pribadi maupun profesional.\n\nDengan semangat kebersamaan, kami percaya bahwa setiap individu memiliki potensi untuk memberikan kontribusi dan menciptakan dampak yang berarti. Di sini, kamu tidak hanya menjadi bagian dari komunitas, tetapi juga bagian dari perjalanan untuk tumbuh dan berkembang bersama.",
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'manager_id'    => $superAdmin->id,
                'key'           => $key,
                'value'         => $value,
            ]);
        }
    }
}
