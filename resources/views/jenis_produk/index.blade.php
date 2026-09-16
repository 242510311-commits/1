@extends('layouts.app')

@section('title', 'Data Jenis Produk')

@section('content')
<div class="container mt-4">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Form Tambah Jenis Produk --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white font-weight-bold">
                    Tambah Jenis Produk
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-produk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_jenis" class="form-label">Nama Jenis Produk</label>
                            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" placeholder="Contoh: Makanan, Minuman" required>
                            @error('nama_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel Data Jenis Produk --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold">
                    Daftar Jenis Produk
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="width: 10%;">#</th>
                                    <th>Nama Jenis</th>
                                    <th class="text-end pe-3" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisProduk as $index => $item)
                                    <tr>
                                        <td class="ps-3">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $item->nama_jenis }}</td>
                                        <td class="text-end pe-3">
                                            <form action="{{ route('jenis-produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            Belum ada data jenis produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection