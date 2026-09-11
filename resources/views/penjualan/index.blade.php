@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h1 class="h3 mb-1">Penjualan</h1>
        <p class="text-muted mb-0">Riwayat dan transaksi penjualan.</p>
    </div>
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
        <i class="bi bi-cart-plus"></i> Transaksi Baru
    </a>
</div>

<form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="search" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Cari nama kasir...">
        <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </div>
</form>

<div class="card shadow-sm border-0">
<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
    <thead class="table-dark">
        <tr>
            <th>#</th><th>Tanggal</th><th>Kasir</th><th>Total</th>
            <th>Metode</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($sales as $sale)
        <tr>
            <td>{{ $sales->firstItem() + $loop->index }}</td>
            <td>{{ $sale->created_at?->translatedFormat('d-m-Y H:i') }}</td>
            <td>{{ $sale->user?->name ?? '-' }}</td>
            <td>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
            <td>{{ $sale->metode_pembayaran }}</td>
            <td>
                <span class="badge {{ $sale->status === 'COMPLETED' ? 'text-bg-success' : 'text-bg-warning' }}">
                    {{ $sale->status }}
                </span>
            </td>
            <td class="d-flex gap-1">
                <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-info btn-sm">Detail</a>
                @can('update', $sale)
                    <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning btn-sm">Edit</a>
                @endcan
                @can('delete', $sale)
                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Batal</button>
                    </form>
                @endcan
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
</div>
<div class="mt-3">{{ $sales->links() }}</div>
@endsection
