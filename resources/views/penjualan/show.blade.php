@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Penjualan #{{ $sale->id }}</h1>
    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4"><strong>Kasir:</strong> {{ $sale->user?->name ?? '-' }}</div>
            <div class="col-md-4"><strong>Tanggal:</strong> {{ $sale->created_at?->translatedFormat('d-m-Y H:i:s') }}</div>
            <div class="col-md-4"><strong>Status:</strong> {{ $sale->status }}</div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                @forelse($sale->itemPenjualan as $item)
                    <tr>
                        <td>{{ $item->produk?->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $item->kuantitas }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Tidak ada item.</td></tr>
                @endforelse
                </tbody>
                <tfoot>
                    <tr><th colspan="3" class="text-end">Total</th>
                        <th>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</th></tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
