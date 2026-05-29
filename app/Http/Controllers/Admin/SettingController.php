<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            // Identitas
            'site_name' => Setting::get('site_name', 'NusaKini'),
            'site_tagline' => Setting::get('site_tagline', ''),
            'site_description' => Setting::get('site_description', ''),
            'site_logo' => Setting::get('site_logo'),
            'site_favicon' => Setting::get('site_favicon'),
            // Kontak
            'office_email' => Setting::get('office_email', ''),
            'office_phone' => Setting::get('office_phone', ''),
            'office_fax' => Setting::get('office_fax', ''),
            'office_whatsapp' => Setting::get('office_whatsapp', ''),
            'office_address' => Setting::get('office_address', ''),
            // Sosial Media
            'facebook_url' => Setting::get('facebook_url', ''),
            'twitter_url' => Setting::get('twitter_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            // Lainnya
            'epaper_link' => Setting::get('epaper_link', ''),
            // SEO
            'meta_description' => Setting::get('meta_description', ''),
            'meta_keywords' => Setting::get('meta_keywords', ''),
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'site_name', 'site_tagline', 'site_description',
            'office_email', 'office_phone', 'office_fax', 'office_whatsapp', 'office_address',
            'facebook_url', 'twitter_url', 'instagram_url',
            'epaper_link',
            'meta_description', 'meta_keywords',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        // Handle file uploads
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => 'storage/' . $path]);
        }

        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => 'storage/' . $path]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
