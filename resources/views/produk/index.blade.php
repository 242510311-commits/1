@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h1 class="h3 mb-1">Produk</h1>
        <p class="text-muted mb-0">Kelola dan lihat daftar produk.</p>
    </div>
    @can('create', App\Models\Produk::class)
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
    @endcan
</div>

<form action="{{ route('produk.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="search" name="search" value="{{ request('search') }}"
               class="form-control" placeholder="Cari nama produk...">
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i> Cari
        </button>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th><th>Foto</th><th>Nama</th><th>Harga Beli</th>
                    <th>Harga Jual</th><th>Stok</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td>
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}"
                                     alt="{{ $product->nama }}" width="55" height="55"
                                     class="rounded object-fit-cover">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width:55px;height:55px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $product->nama }}</td>
                        <td>Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $product->stok <= 5 ? 'text-bg-warning' : 'text-bg-success' }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('produk.show', $product) }}" class="btn btn-info btn-sm">Detail</a>
                                @can('update', $product)
                                    <a href="{{ route('produk.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                                @endcan
                                @can('delete', $product)
                                    <form action="{{ route('produk.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Data produk tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $products->links() }}</div>
@endsection
