@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Laporan</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $laporan->judul }}</h5>
            <p class="card-text"><strong>Kategori:</strong> {{ $laporan->kategori->kategori ?? '-' }}</p>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $laporan->deskripsi }}</p>
            <p class="card-text"><strong>Status:</strong> {{ $laporan->status }}</p>
        </div>
    </div>

    <a href="{{ route('teknisi.dashboard') }}" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors mt-3">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Kembali
    </a>
</div>
@endsection
