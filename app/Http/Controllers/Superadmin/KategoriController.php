<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('created_at', 'desc')->paginate(10);
        return view('superadmin.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah ada.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('superadmin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return view('superadmin.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('superadmin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id,
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah ada.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('superadmin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Check if kategori is being used by any laporan
        if ($kategori->laporans()->count() > 0) {
            return redirect()->route('superadmin.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh laporan.');
        }

        $kategori->delete();

        return redirect()->route('superadmin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
