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

    <a href="{{ route('dashboard.teknisi') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
