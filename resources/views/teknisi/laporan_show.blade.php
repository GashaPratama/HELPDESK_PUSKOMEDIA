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

    <a href="{{ route('dashboard.teknisi') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
