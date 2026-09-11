@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container mt-4">

    {{-- ================= HEADER DASHBOARD ================= --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">
            Ringkasan Hari Ini
        </h1>

        <p class="text-muted mb-0">
            {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
        </p>
    </div>


    {{-- ================= ADMIN SALES ================= --}}
    @if(auth()->user()->hasRole('admin'))

        <div class="mb-4">
            <h2 class="fw-bold">
                Today's Sales
            </h2>

            <p class="text-muted">
                Ringkasan penjualan hari ini
            </p>
        </div>

        <div class="row g-4 mb-5">

            {{-- Total Penjualan --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-2">
                                    Total Nilai Penjualan Hari Ini
                                </p>

                                <h3 class="fw-bold mb-0">
                                    Rp {{ number_format($ringkasan['total_penjualan'] ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="fs-1 text-success">
                                <i class="bi bi-cash-stack"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Total Transaksi --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-2">
                                    Jumlah Transaksi Hari Ini
                                </p>

                                <h3 class="fw-bold mb-0">
                                    {{ $ringkasan['total_transaksi'] ?? 0 }}
                                </h3>
                            </div>

                            <div class="fs-1 text-primary">
                                <i class="bi bi-receipt"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- ================= PAYMENT ================= --}}
        <div class="mb-4">
            <h2 class="fw-bold">
                Cash & Payment Status
            </h2>

            <p class="text-muted">
                Ringkasan metode pembayaran hari ini
            </p>
        </div>

        <div class="row g-4 mb-5">

            {{-- Cash --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-2">
                                    Total Pembayaran Tunai
                                </p>

                                <h3 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($ringkasan['total_cash'] ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="fs-1 text-success">
                                <i class="bi bi-wallet2"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Non Tunai --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-2">
                                    Total Pembayaran Non-Tunai
                                </p>

                                <h3 class="fw-bold text-primary mb-0">
                                    Rp {{ number_format($ringkasan['total_non_tunai'] ?? 0, 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="fs-1 text-primary">
                                <i class="bi bi-credit-card"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    @endif


    {{-- ================= INVENTORY STATUS ================= --}}
    <div class="mb-4">
        <h2 class="fw-bold">
            Critical Inventory Status
        </h2>

        <p class="text-muted">
            Pantau produk dengan stok rendah dan stok habis.
        </p>
    </div>


    <div class="row g-4 mb-5">

        {{-- ================= STOK RENDAH ================= --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                                Stok Rendah
                            </h5>

                            <small class="text-muted">
                                Produk yang perlu segera diperhatikan
                            </small>
                        </div>

                        <span class="badge bg-warning text-dark">
                            {{ $produkStokRendah->total() }}
                        </span>

                    </div>
                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Nama Produk</th>
                                    <th class="text-center pe-4">Stok</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($produkStokRendah as $index => $produk)

                                    <tr>

                                        <td class="ps-4">
                                            {{ $produkStokRendah->firstItem() + $index }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $produk->nama }}
                                        </td>

                                        <td class="text-center pe-4">

                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                {{ $produk->stok }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="3" class="text-center py-5">

                                            <i class="bi bi-check-circle fs-1 text-success"></i>

                                            <p class="text-muted mt-2 mb-0">
                                                Semua produk memiliki stok yang aman.
                                            </p>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                @if($produkStokRendah->hasPages())

                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-center">
                            {{ $produkStokRendah->links() }}
                        </div>
                    </div>

                @endif

            </div>

        </div>


        {{-- ================= STOK HABIS ================= --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-x-circle text-danger"></i>
                                Stok Habis
                            </h5>

                            <small class="text-muted">
                                Produk yang tidak tersedia
                            </small>

                        </div>

                        <span class="badge bg-danger">
                            {{ $produkStokHabis->total() }}
                        </span>

                    </div>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Nama Produk</th>
                                    <th class="text-center pe-4">Stok</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($produkStokHabis as $index => $produk)

                                    <tr>

                                        <td class="ps-4">
                                            {{ $produkStokHabis->firstItem() + $index }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $produk->nama }}
                                        </td>

                                        <td class="text-center pe-4">

                                            <span class="badge bg-danger px-3 py-2">
                                                {{ $produk->stok }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="text-center py-5">

                                            <i class="bi bi-check-circle fs-1 text-success"></i>

                                            <p class="text-muted mt-2 mb-0">
                                                Tidak ada produk yang stoknya habis.
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                @if($produkStokHabis->hasPages())

                    <div class="card-footer bg-white border-0 py-3">

                        <div class="d-flex justify-content-center">
                            {{ $produkStokHabis->links() }}
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- ================= BEST SELLER ================= --}}
    <div class="mb-4">

        <h2 class="fw-bold">
            Best Seller Products
        </h2>

        <p class="text-muted">
            Produk dengan jumlah penjualan terbanyak.
        </p>

    </div>


    <div class="card border-0 shadow-sm mb-5">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th class="ps-4">
                                #
                            </th>

                            <th>
                                Nama Produk
                            </th>

                            <th class="text-center">
                                Stok
                            </th>

                            <th class="text-center pe-4">
                                Unit Terjual
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($produkTerlaris as $index => $produk)

                            <tr>

                                <td class="ps-4">
                                    {{ $index + 1 }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $produk->nama }}
                                </td>

                                <td class="text-center">

                                    @if($produk->stok <= 0)

                                        <span class="badge bg-danger">
                                            Habis
                                        </span>

                                    @elseif($produk->stok <= 5)

                                        <span class="badge bg-warning text-dark">
                                            {{ $produk->stok }}
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            {{ $produk->stok }}
                                        </span>

                                    @endif

                                </td>

                                <td class="text-center pe-4">

                                    <span class="fw-bold">
                                        {{ $produk->total_terjual ?? 0 }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-5">

                                    <i class="bi bi-bar-chart fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data penjualan.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection