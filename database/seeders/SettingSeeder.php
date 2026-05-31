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
            'community_name'            => 'Aplikasi Member Komunitas',
            'community_logo'            => null,
            'email'                     => 'amk@mail.com',
            'telephone'                 => fake()->phoneNumber(),
            'address'                   => fake()->address(),
            'x_account_url'             => null,
            'facebook_account_url'      => null,
            'linkedin_account_url'      => null,
            'skype_account_url'         => null,
            'instagram_account_url'     => null,
            'youtube_account_url'       => null,
            'account_holder_name'       => 'Aplikasi Member Komunitas',
            'account_number'            => '000000001111',
            'bank_name'                 => 'Bank AMK',
            'membership_fee'            => '50000',
            'membership_duration'       => '12',
            'invoice_countdown'         => '24',
            'primary_color'             => '#007FFF',
            'surface_color'             => '#E5F2FF',
            'background_image'          => null,
            'hero_title'                => null,
            'hero_description'          => null,
            'about_image'               => null,
            'about_title'               => null,
            'about_description'         => null,
            'member_stat_title'         => null,
            'member_stat_description'   => null,
            'stat_member_active'        => '567',
            'stat_member_inactive'      => '33',
            'stat_member_company'       => '50',
            'stat_member_personal'      => '550',
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key'   => $key,
                'value' => $value,
            ]);
        }
    }
}
