@extends('layouts.app')

@section('title', $mode === 'edit' ? 'Edit Transaksi' : 'Transaksi POS')

@section('content')

<div class="container-fluid py-3">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                Transaksi POS
            </h1>

            <p class="text-muted mb-0">
                Transaksi #{{ $sale->id }} · {{ auth()->user()->name }}
            </p>
        </div>

        <a href="{{ route('penjualan.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

    </div>


    <div class="row g-4">

        {{-- =========================================================
             DAFTAR PRODUK
        ========================================================== --}}
        <div class="col-lg-6">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-white fw-semibold py-3">
                    <i class="bi bi-box-seam me-2"></i>
                    Daftar Produk
                </div>


                <div class="card-body">

                    {{-- SEARCH --}}
                    <form method="GET"
                          action="{{ route('penjualan.create') }}"
                          class="mb-3">

                        <div class="input-group">

                            <input type="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Cari produk...">

                            <button class="btn btn-outline-secondary"
                                    type="submit">
                                <i class="bi bi-search"></i>
                                Cari
                            </button>

                        </div>

                    </form>


                    {{-- LIST PRODUK --}}
                    <div style="max-height:60vh; overflow-y:auto; padding-right:5px;">

                        @forelse($products as $product)

                            <form method="POST"
                                  action="{{ route('itempenjualan.store') }}"
                                  class="d-flex align-items-center gap-2 mb-2">

                                @csrf

                                <input type="hidden"
                                       name="product_id"
                                       value="{{ $product->id }}">


                                {{-- INFORMASI PRODUK --}}
                                <div class="flex-grow-1 border rounded p-2">

                                    <div class="fw-semibold">
                                        {{ $product->nama }}
                                    </div>

                                    <small class="text-muted">

                                        Rp
                                        {{ number_format($product->harga_jual, 0, ',', '.') }}

                                        ·

                                        Stok {{ $product->stok }}

                                    </small>

                                </div>


                                {{-- QUANTITY --}}
                                <input type="number"
                                       name="quantity"
                                       value="1"
                                       min="1"
                                       max="{{ max(1, $product->stok) }}"
                                       class="form-control"
                                       style="width:90px;"
                                       {{ $product->stok < 1 ? 'disabled' : '' }}>


                                {{-- TAMBAH --}}
                                <button type="submit"
                                        class="btn btn-primary"
                                        {{ $product->stok < 1 ? 'disabled' : '' }}>

                                    <i class="bi bi-plus-lg"></i>

                                </button>

                            </form>

                        @empty

                            <div class="text-center text-muted py-4">

                                <i class="bi bi-box fs-1"></i>

                                <p class="mb-0 mt-2">
                                    Produk tidak ditemukan.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
             KERANJANG
        ========================================================== --}}
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white fw-semibold py-3">

                    <i class="bi bi-cart3 me-2"></i>
                    Keranjang

                </div>


                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Produk</th>

                                <th>Harga</th>

                                <th style="width:150px">
                                    Qty
                                </th>

                                <th>Subtotal</th>

                                <th style="width:60px">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($sale->itemPenjualan as $item)

                            <tr>

                                {{-- PRODUK --}}
                                <td>
                                    {{ $item->produk?->nama ?? '-' }}
                                </td>


                                {{-- HARGA --}}
                                <td>
                                    Rp
                                    {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>


                                {{-- QTY --}}
                                <td>

                                    @can('update', $item)

                                        <form method="POST"
                                              action="{{ route('itempenjualan.update', $item) }}"
                                              class="d-flex gap-1">

                                            @csrf

                                            @method('PUT')

                                            <input type="number"
                                                   name="quantity"
                                                   min="1"
                                                   value="{{ $item->kuantitas }}"
                                                   class="form-control form-control-sm">

                                            <button class="btn btn-warning btn-sm"
                                                    title="Simpan jumlah">

                                                <i class="bi bi-check"></i>

                                            </button>

                                        </form>

                                    @else

                                        {{ $item->kuantitas }}

                                    @endcan

                                </td>


                                {{-- SUBTOTAL --}}
                                <td>

                                    Rp
                                    {{ number_format($item->subtotal, 0, ',', '.') }}

                                </td>


                                {{-- HAPUS --}}
                                <td>

                                    @can('delete', $item)

                                        <form method="POST"
                                              action="{{ route('itempenjualan.destroy', $item) }}"
                                              onsubmit="return confirm('Hapus item ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    @endcan

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-cart-x fs-1"></i>

                                    <p class="mb-0 mt-2">
                                        Keranjang masih kosong.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>



                {{-- =====================================================
                     TOTAL & PEMBAYARAN
                ====================================================== --}}
                <div class="card-footer bg-white p-3">

                    {{-- TOTAL --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <span class="fs-5 fw-bold">
                            Total
                        </span>

                        <span class="fs-4 fw-bold">

                            Rp
                            {{ number_format($sale->total_pembayaran, 0, ',', '.') }}

                        </span>

                    </div>


                    {{-- =================================================
                         CHECKOUT
                    ================================================== --}}
                    @if($sale->status === 'OPEN')

                        <form method="POST"
                              action="{{ route('penjualan.update', $sale) }}"
                              onsubmit="return confirm('Yakin ingin checkout transaksi ini?')">

                            @csrf

                            @method('PUT')


                            {{-- METODE PEMBAYARAN --}}
                            <label class="form-label fw-semibold">

                                <i class="bi bi-credit-card me-1"></i>
                                Metode Pembayaran

                            </label>


                            <select name="payment_method"
                                    id="payment_method"
                                    class="form-select mb-3"
                                    required
                                    onchange="ubahMetodePembayaran(this.value)">

                                <option value="">
                                    Pilih pembayaran
                                </option>

                                <option value="CASH">
                                    Cash / Tunai
                                </option>

                                <option value="QRIS">
                                    QRIS
                                </option>

                            </select>



                            {{-- =================================================
                                 PANEL QRIS
                            ================================================== --}}
                            <div id="qris-panel"
                                 class="qris-panel mb-3"
                                 style="display:none;">

                                <div class="row align-items-center">

                                    {{-- QR CODE --}}
                                    <div class="col-md-5 text-center">

                                        <div class="qris-image-wrapper">

                                            <img src="{{ asset('images/qris.png') }}"
                                                 alt="QRIS POS Rizal"
                                                 class="qris-image">

                                        </div>

                                    </div>


                                    {{-- INFORMASI --}}
                                    <div class="col-md-7">

                                        <span class="qris-badge">

                                            <i class="bi bi-qr-code-scan"></i>

                                            Pembayaran QRIS

                                        </span>


                                        <h5 class="fw-bold mt-3">
                                            Scan QR untuk membayar
                                        </h5>


                                        <p class="text-muted small">

                                            Silakan scan QR Code di samping
                                            menggunakan aplikasi pembayaran
                                            yang mendukung QRIS.

                                        </p>


                                        <div class="qris-total">

                                            <span>
                                                Total Pembayaran
                                            </span>

                                            <strong>
                                                Rp
                                                {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                            </strong>

                                        </div>


                                        <div class="payment-apps mt-3">

                                            <span>DANA</span>
                                            <span>OVO</span>
                                            <span>GoPay</span>
                                            <span>ShopeePay</span>
                                            <span>LinkAja</span>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            {{-- =================================================
                                 PANEL CASH
                            ================================================== --}}
                            <div id="cash-panel"
                                 class="alert alert-light border mb-3"
                                 style="display:none;">

                                <div class="d-flex align-items-center">

                                    <i class="bi bi-cash-stack fs-2 text-success me-3"></i>

                                    <div>

                                        <strong>
                                            Pembayaran Tunai
                                        </strong>

                                        <p class="text-muted mb-0">
                                            Pembayaran dilakukan menggunakan
                                            uang tunai.
                                        </p>

                                    </div>

                                </div>

                            </div>



                            {{-- CHECKOUT BUTTON --}}
                            <button type="submit"
                                    class="btn btn-success w-100"
                                    {{ $sale->itemPenjualan->isEmpty() ? 'disabled' : '' }}>

                                <i class="bi bi-check-circle"></i>

                                Checkout

                            </button>

                        </form>



                        {{-- =================================================
                             BATAL TRANSAKSI
                        ================================================== --}}
                        @can('delete', $sale)

                            <form method="POST"
                                  action="{{ route('penjualan.destroy', $sale) }}"
                                  class="mt-2"
                                  onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">

                                @csrf

                                @method('DELETE')

                                <button class="btn btn-outline-danger w-100">

                                    <i class="bi bi-x-circle"></i>

                                    Batalkan Transaksi

                                </button>

                            </form>

                        @endcan

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     CSS
============================================================= --}}
@push('styles')

<style>

    /* =========================================
       QRIS PANEL
    ========================================= */

    .qris-panel {

        padding: 20px;

        border-radius: 12px;

        background: linear-gradient(
            135deg,
            #f1f8ff,
            #eef7ff
        );

        border: 1px solid #dbeafe;

    }


    .qris-image-wrapper {

        display: inline-flex;

        padding: 12px;

        background: white;

        border-radius: 12px;

        box-shadow:
            0 4px 15px rgba(0, 0, 0, .08);

    }


    .qris-image {

        width: 180px;

        height: 180px;

        object-fit: contain;

        display: block;

    }


    /* =========================================
       QRIS BADGE
    ========================================= */

    .qris-badge {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 7px 12px;

        border-radius: 7px;

        background: #0d6efd;

        color: white;

        font-weight: 600;

        font-size: 13px;

    }


    /* =========================================
       TOTAL QRIS
    ========================================= */

    .qris-total {

        display: flex;

        justify-content: space-between;

        align-items: center;

        padding: 12px 14px;

        background: white;

        border: 1px solid #e2e8f0;

        border-radius: 8px;

    }


    .qris-total span {

        color: #6c757d;

        font-size: 13px;

    }


    .qris-total strong {

        color: #198754;

        font-size: 18px;

    }


    /* =========================================
       PAYMENT APPS
    ========================================= */

    .payment-apps {

        display: flex;

        flex-wrap: wrap;

        gap: 6px;

    }


    .payment-apps span {

        padding: 5px 9px;

        border: 1px solid #8723ca;

        background: white;

        border-radius: 6px;

        font-size: 11px;

        font-weight: 600;

        color: #495057;

    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 768px) {

        .qris-panel {

            text-align: center;

        }


        .qris-image {

            width: 160px;

            height: 160px;

        }


        .qris-total {

            text-align: left;

            margin-top: 15px;

        }


        .payment-apps {

            justify-content: center;

        }

    }

</style>

@endpush



{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
@push('scripts')

<script>

    function ubahMetodePembayaran(metode) {

        const qrisPanel = document.getElementById('qris-panel');

        const cashPanel = document.getElementById('cash-panel');


        // Sembunyikan semua panel

        qrisPanel.style.display = 'none';

        cashPanel.style.display = 'none';


        // Tampilkan sesuai metode

        if (metode === 'QRIS') {

            qrisPanel.style.display = 'block';

        }


        if (metode === 'CASH') {

            cashPanel.style.display = 'block';

        }

    }


    // Saat halaman selesai dimuat

    document.addEventListener('DOMContentLoaded', function () {

        const paymentMethod =
            document.getElementById('payment_method');


        if (paymentMethod) {

            ubahMetodePembayaran(paymentMethod.value);

        }

    });

</script>

@endpush

@endsection