<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller


{
    // Tampilkan halaman profil utama
    public function index()
    {
        return view('customer.profil');
    }

    // Halaman Edit
    public function editNama()
    {
        return view('customer.edit-nama');
    }

    public function editEmail()
    {
        return view('customer.edit-email');
    }

    public function editPassword()
{
    return view('customer.edit-password');
}


    public function editFoto()
    {
        return view('customer.edit-foto');
    }

    // Proses Update Nama
    public function updateNama(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->save();

        return back()->with('success', 'Nama berhasil diperbarui.');
    }

    // Proses Update Email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:user,email,' . Auth::user()->id_user . ',id_user',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email berhasil diperbarui.');
    }

    // Proses Update Password
    public function updatePassword(Request $request)
{
    $request->validate([
        'password_lama' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Cek apakah password lama benar
    if (!Hash::check($request->password_lama, $user->password)) {
        return back()->withErrors(['password_lama' => '❌ Password lama tidak sesuai']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', '✅ Password berhasil diperbarui.');
}

    // Proses Update Foto Profil
    public function updateFoto(Request $request)
    {
        // Debug: Log request data
        \Log::info('Update Foto Request:', [
            'hasFile' => $request->hasFile('foto_profil'),
            'file' => $request->file('foto_profil'),
            'all' => $request->all()
        ]);

        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        try {
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                
                // Debug: Log file info
                \Log::info('File info:', [
                    'originalName' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mimeType' => $file->getMimeType(),
                    'isValid' => $file->isValid()
                ]);

                // Hapus foto lama jika ada
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }

                // Simpan foto baru
                $path = $file->store('foto_profil', 'public');
                
                // Debug: Log path
                \Log::info('File stored at:', ['path' => $path]);
                
                $user->foto_profil = $path;
                $user->save();

                // Debug: Log user update
                \Log::info('User updated:', ['foto_profil' => $user->foto_profil]);

                return back()->with('success', 'Foto profil berhasil diperbarui.');
            } else {
                return back()->withErrors(['foto_profil' => 'Tidak ada file yang diupload.']);
            }
        } catch (\Exception $e) {
            \Log::error('Error updating foto:', ['error' => $e->getMessage()]);
            return back()->withErrors(['foto_profil' => 'Gagal menyimpan foto: ' . $e->getMessage()]);
        }
    }
}
