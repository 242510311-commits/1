@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white fw-semibold">Detail Produk</div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4 text-center">
                @if($produk->foto)
                    <img src="{{ asset('storage/' . $produk->foto) }}"
                         alt="Foto {{ $produk->nama }}"
                         class="img-fluid rounded" style="max-height:250px; object-fit:cover;">
                @else
                    <div class="bg-light rounded p-5 text-muted">
                        <i class="bi bi-image fs-1"></i><br>Tidak ada foto
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h3>{{ $produk->nama }}</h3>
                <hr>
                <p><strong>Harga Beli:</strong> Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</p>
                <p><strong>Harga Jual:</strong> Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                <p><strong>Stok:</strong> {{ $produk->stok }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white">
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        @can('update', $produk)
            <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning">Edit</a>
        @endcan
    </div>
</div>
@endsection
