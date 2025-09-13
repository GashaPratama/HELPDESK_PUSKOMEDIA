@extends('layouts.app')

@section('title', 'Dashboard Customer Service')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800">📋 Dashboard Customer Service</h1>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-lg rounded-2xl border border-gray-100">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-3">Kategori Kendala</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Media</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Notes</th>
                    <th class="px-6 py-3">Kirim ke Teknisi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $laporan->kategori->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $laporan->customer->nama_lengkap ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if(!empty($laporan->foto))
                                <a href="{{ asset('storage/' . $laporan->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Bukti Foto" class="w-14 h-14 object-cover rounded-lg shadow">
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>

                        {{-- FORM UPDATE STATUS & NOTES --}}
                        <td class="px-6 py-4">
                            <form action="{{ route('cs.laporan.update', $laporan->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                <select name="status" class="border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Diterima" {{ $laporan->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                        </td>
                        <td class="px-6 py-4">
                            <input type="text" name="notes" value="{{ $laporan->notes ?? '' }}" class="w-full border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan catatan...">
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- FORM KIRIM DIPISAH --}}
                            <form action="{{ route('cs.laporan.kirim', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                                    Kirim
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 flex items-center space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow">Simpan</button>
                            </form>
                            <form action="{{ route('cs.laporan.delete', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-400">Tidak ada laporan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
