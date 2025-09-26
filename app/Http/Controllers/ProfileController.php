<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show profile edit page
     */
    public function edit()
    {
        $user = Auth::user();
        $backUrl = $this->getBackUrl();
        return view('profile.edit', compact('user', 'backUrl'));
    }

    /**
     * Get the appropriate back URL based on user role
     */
    private function getBackUrl()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'superadmin':
                return route('superadmin.dashboard');
            case 'customer':
                return route('dashboard.customer');
            case 'customer_service':
                return route('dashboard.customerservice');
            case 'teknisi':
                return route('teknisi.dashboard');
            default:
                return url()->previous() ?: route('login');
        }
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('user')->ignore($user->id_user, 'id_user')],
            'no_telpon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date|before:today',
            'alamat' => 'nullable|string|max:500',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan oleh user lain',
            'no_telpon.max' => 'Nomor telepon maksimal 20 karakter',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'foto_profil.image' => 'File harus berupa gambar',
            'foto_profil.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            // Handle photo upload
            if ($request->hasFile('foto_profil')) {
                // Delete old photo if exists
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }

                // Upload new photo
                $file = $request->file('foto_profil');
                $filename = 'profile-' . $user->id_user . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                
                $user->foto_profil = $path;
            }

            // Update user data
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_telpon = $request->no_telpon;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->alamat = $request->alamat;
            $user->save();

            return redirect($this->getBackUrl())->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.edit')->with('error', 'Password lama tidak sesuai!');
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect($this->getBackUrl())->with('success', 'Password berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Gagal memperbarui password: ' . $e->getMessage());
        }
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        try {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $user->foto_profil = null;
            $user->save();

            return redirect($this->getBackUrl())->with('success', 'Foto profil berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('profile.edit')->with('error', 'Gagal menghapus foto profil: ' . $e->getMessage());
        }
    }
}