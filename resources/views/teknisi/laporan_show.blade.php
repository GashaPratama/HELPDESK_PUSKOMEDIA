@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Laporan</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $laporan->judul }}</h4>
            <p><strong>Customer:</strong> {{ $laporan->customer->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $laporan->status }}</p>
            <p><strong>Notes:</strong> {{ $laporan->notes ?? '-' }}</p>
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
