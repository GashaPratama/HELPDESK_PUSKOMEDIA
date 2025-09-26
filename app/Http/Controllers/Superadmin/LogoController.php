<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LogoController extends Controller
{
    /**
     * Show logo management page
     */
    public function index()
    {
        $currentLogo = SystemSetting::getValue('login_logo', null);
        
        return view('superadmin.logo.index', compact('currentLogo'));
    }

    /**
     * Update logo
     */
    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            // Delete old logo if exists
            $oldLogo = SystemSetting::getValue('login_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Upload new logo
            $file = $request->file('logo');
            $filename = 'logo-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');

            // Save to database
            SystemSetting::setValue(
                'login_logo', 
                $path, 
                'image', 
                'Logo untuk halaman login'
            );

            return redirect()->route('superadmin.logo.index')
                ->with('success', 'Logo berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->route('superadmin.logo.index')
                ->with('error', 'Gagal mengupload logo: ' . $e->getMessage());
        }
    }

    /**
     * Remove logo
     */
    public function destroy()
    {
        try {
            $currentLogo = SystemSetting::getValue('login_logo');
            
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }

            SystemSetting::where('key', 'login_logo')->delete();

            return redirect()->route('superadmin.logo.index')
                ->with('success', 'Logo berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('superadmin.logo.index')
                ->with('error', 'Gagal menghapus logo: ' . $e->getMessage());
        }
    }
}
