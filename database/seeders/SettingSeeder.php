<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'community_name'        => 'Aplikasi Member Komunitas',
            'community_logo'        => null,
            'email'                 => 'amk@mail.com',
            'telephone'             => fake()->phoneNumber(),
            'address'               => 'Gedung Cipta Karya, Jl. Pahlawan Sejahtera No. 5, Surabaya',
            'x_account_url'         => null,
            'facebook_account_url'  => null,
            'linkedin_account_url'  => null,
            'skype_account_url'     => null,
            'instagram_account_url' => null,
            'youtube_account_url'   => null,
            'account_holder_name'   => 'Aplikasi Member Komunitas',
            'account_number'        => '000000001111',
            'bank_name'             => 'Bank AMK',
            'membership_fee'        => '50000',
            'membership_duration'   => '12',
            'invoice_countdown'     => '24',
            'primary_color'         => '#007FFF',
            'surface_color'         => '#E5F2FF',
            'background_image'      => null,
            'hero_title'            => 'Bangun Koneksi dan Tumbuh Bersama',
            'hero_description'      => 'Terhubung dengan individu dari berbagai latar belakang, berbagi ide, dan membangun kolaborasi dalam komunitas inklusif untuk berkembang bersama serta menciptakan dampak nyata.',
            'about_image'           => null,
            'about_title'           => 'Tentang',
            'about_description'     => 'Komunitas ini adalah ruang terbuka bagi siapa saja yang ingin belajar, berkembang, dan saling terhubung dalam lingkungan yang positif dan kolaboratif. Kami menghadirkan berbagai kesempatan untuk bertukar wawasan, membangun relasi, serta berpartisipasi dalam kegiatan yang mendorong pertumbuhan pribadi maupun profesional. Dengan semangat kebersamaan, kami percaya bahwa setiap individu memiliki potensi untuk memberikan kontribusi dan menciptakan dampak yang berarti. Di sini, kamu tidak hanya menjadi bagian dari komunitas, tetapi juga bagian dari perjalanan untuk tumbuh dan berkembang bersama.',
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
