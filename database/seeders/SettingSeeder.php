<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'NusaKini',
            'site_tagline' => 'Portal Berita Modern, Kredibel, & Tepercaya',
            'site_description' => 'NusaKini adalah portal media digital independen yang berfokus menyajikan jurnalisme investigatif, mendalam, dan bermutu tinggi seputar politik, ekonomi, sains, dan gaya hidup kontemporer Indonesia.',
            'office_address' => 'Gedung Nusa Media Center, Lantai 12-14, Jl. Jenderal Sudirman Kav. 21, Jakarta Selatan, 12190',
            'office_phone' => '(021) 555-0199',
            'office_fax' => '(021) 555-0200',
            'office_whatsapp' => '+62 811-2222-3333',
            'office_email' => 'redaksi@nusakini.com',
            'facebook_url' => 'https://facebook.com/nusakini',
            'twitter_url' => 'https://twitter.com/nusakini',
            'instagram_url' => 'https://instagram.com/nusakini',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
