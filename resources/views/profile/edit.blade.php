@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header text-white border-0 py-4" style="background: linear-gradient(135deg, #111827 0%, #1f2937 45%, #0d6efd 100%);">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <p class="mb-1 text-uppercase small text-white-50">Pengaturan akun</p>
                            <h3 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i>Edit Profil</h3>
                        </div>
                        <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold text-dark">
                            <i class="bi bi-eye me-1"></i>Lihat Profil
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="rounded-4 border bg-light p-4 text-center h-100 d-flex flex-column justify-content-center">
                                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow" style="width: 110px; height: 110px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); font-size: 2.5rem;">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <h5 class="mt-3 mb-1 fw-bold text-dark">{{ $user->name }}</h5>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-bold">Nama</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                                               value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" id="email"
                                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                                               value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label fw-bold">Password Baru <span class="text-muted fw-normal">(opsional)</span></label>
                                        <input type="password" name="password" id="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               placeholder="Kosongkan jika tidak ingin mengubah password">
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-semibold">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection