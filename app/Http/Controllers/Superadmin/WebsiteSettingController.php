<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    /**
     * Display website settings page
     */
    public function index()
    {
        $settings = WebsiteSetting::getSettings();
        return view('superadmin.website-settings', compact('settings'));
    }

    /**
     * Update website settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'website_description' => 'nullable|string|max:1000',
            'whatsapp_cs' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'phone_1' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'phone_2' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'background_type' => 'required|in:gradient,image,solid',
            'background_color' => 'nullable|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'website_name.required' => 'Nama website wajib diisi',
            'website_name.max' => 'Nama website maksimal 255 karakter',
            'website_description.max' => 'Deskripsi website maksimal 1000 karakter',
            'whatsapp_cs.max' => 'Nomor WhatsApp maksimal 20 karakter',
            'whatsapp_cs.regex' => 'Format nomor WhatsApp tidak valid',
            'phone_1.max' => 'Nomor HP 1 maksimal 20 karakter',
            'phone_1.regex' => 'Format nomor HP 1 tidak valid',
            'phone_2.max' => 'Nomor HP 2 maksimal 20 karakter',
            'phone_2.regex' => 'Format nomor HP 2 tidak valid',
            'email_1.email' => 'Format email 1 tidak valid',
            'email_1.max' => 'Email 1 maksimal 255 karakter',
            'email_2.email' => 'Format email 2 tidak valid',
            'email_2.max' => 'Email 2 maksimal 255 karakter',
            'address.max' => 'Alamat maksimal 500 karakter',
            'background_image.image' => 'File harus berupa gambar',
            'background_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, atau WebP',
            'background_image.max' => 'Ukuran gambar maksimal 5MB',
            'background_type.required' => 'Tipe background wajib dipilih',
            'background_type.in' => 'Tipe background tidak valid',
            'background_color.regex' => 'Format warna tidak valid (contoh: #FF0000)',
        ]);

        try {
            $updateData = [
                'website_name' => $request->website_name,
                'website_description' => $request->website_description,
                'whatsapp_cs' => $request->whatsapp_cs,
                'phone_1' => $request->phone_1,
                'phone_2' => $request->phone_2,
                'email_1' => $request->email_1,
                'email_2' => $request->email_2,
                'address' => $request->address,
                'background_type' => $request->background_type,
                'background_color' => $request->background_color,
            ];

            // Handle background image upload
            if ($request->hasFile('background_image')) {
                $settings = WebsiteSetting::getSettings();
                
                // Delete old background image if exists
                if ($settings->background_image && Storage::disk('public')->exists($settings->background_image)) {
                    Storage::disk('public')->delete($settings->background_image);
                }

                // Upload new background image
                $file = $request->file('background_image');
                $filename = 'background-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('backgrounds', $filename, 'public');
                
                $updateData['background_image'] = $path;
            }

            $settings = WebsiteSetting::updateSettings($updateData);

            return redirect()->route('superadmin.website-settings')
                ->with('success', 'Pengaturan website berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->route('superadmin.website-settings')
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }
}