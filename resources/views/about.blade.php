@extends('layouts.app')

@section('title', 'Tentang Perusahaan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-dark text-white py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-uppercase text-light-emphasis">POS Rizal</small>
                            <h2 class="fw-bold mb-0 mt-2">Tentang Perusahaan</h2>
                        </div>
                        <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                            <i class="bi bi-building fs-4"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center g-4 mb-4">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="position-relative d-flex justify-content-center align-items-center" style="width: 220px; height: 220px;">
                                <div class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center shadow" style="width: 180px; height: 180px; font-size: 6rem; font-weight: 700; border: 6px solid #fff; position: relative; z-index: 1;">
                                    R
                                </div>
                                <div class="position-absolute rounded-circle" style="width: 210px; height: 210px; background: rgba(23, 104, 214, 0.08); z-index: 0;"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-3 text-center text-md-start">POS Rizal</h3>
                            <p class="text-muted mb-3">
                                POS Rizal adalah solusi bisnis untuk membantu usaha retail, minimarket, dan toko modern
                                dalam mengelola penjualan, stok produk, serta laporan transaksi dengan cepat dan akurat.
                            </p>
                            <p class="text-muted mb-0">
                                Kami hadir untuk mempermudah proses transaksi harian dan memberikan data yang jelas
                                agar pemilik usaha bisa mengambil keputusan lebih tepat.
                            </p>
                        </div>
                    </div>

                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <div class="border rounded-4 h-100 p-4 bg-light text-center">
                                <div class="text-primary mb-3 d-flex justify-content-center">
                                    <i class="bi bi-bullseye fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Visi</h5>
                                <p class="text-muted mb-0">
                                    Menjadi sistem kasir yang andal, cepat, dan mudah digunakan untuk mendukung usaha yang berkembang.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-4 h-100 p-4 bg-light text-center">
                                <div class="text-primary mb-3 d-flex justify-content-center">
                                    <i class="bi bi-flag fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Misi</h5>
                                <p class="text-muted mb-0">
                                    Membantu UMKM dalam mengelola transaksi dan stok secara efisien dengan teknologi yang sederhana.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-4 h-100 p-4 bg-light text-center">
                                <div class="text-primary mb-3 d-flex justify-content-center">
                                    <i class="bi bi-heart fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Nilai</h5>
                                <p class="text-muted mb-0">
                                    Simpel, cepat, akurat, dan selalu berorientasi pada kemudahan pengguna dalam menjalankan bisnis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="text-center mb-3">
                            <h5 class="fw-bold mb-0">Foto Perusahaan</h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img src="https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=900&q=80"
                                 alt="Foto perusahaan"
                                 class="img-fluid rounded-4 shadow-sm"
                                 style="max-height: 260px; width: 100%; object-fit: cover; border: 4px solid #fff;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
