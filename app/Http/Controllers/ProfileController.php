@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="fw-bold mb-1">Profil Saya</h1>
        <p class="text-muted mb-0">
            Kelola informasi akun POS Rizal kamu.
        </p>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="row g-4">

        {{-- PROFILE CARD --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm profile-card">

                <div class="card-body text-center p-4">

                    {{-- Avatar --}}
                    <div class="profile-avatar mx-auto mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h3 class="fw-bold mb-1">
                        {{ $user->name }}
                    </h3>

                    <p class="text-muted mb-3">
                        {{ $user->email }}
                    </p>

                    {{-- Role --}}
                    @if($user->role === 'admin')
                        <span class="badge bg-primary px-3 py-2">
                            <i class="bi bi-shield-check me-1"></i>
                            Administrator
                        </span>
                    @else
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-person-workspace me-1"></i>
                            Kasir
                        </span>
                    @endif

                    <hr class="my-4">

                    <div class="text-start">

                        <div class="profile-info">
                            <i class="bi bi-person"></i>

                            <div>
                                <small class="text-muted">
                                    Nama
                                </small>

                                <div class="fw-semibold">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>

                        <div class="profile-info">
                            <i class="bi bi-envelope"></i>

                            <div>
                                <small class="text-muted">
                                    Email
                                </small>

                                <div class="fw-semibold">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>

                        <div class="profile-info">
                            <i class="bi bi-shield-check"></i>

                            <div>
                                <small class="text-muted">
                                    Role
                                </small>

                                <div class="fw-semibold text-capitalize">
                                    {{ $user->role }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>


        {{-- EDIT PROFILE --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Profil
                    </h4>

                    <p class="text-muted mb-0">
                        Perbarui informasi akun kamu.
                    </p>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('profile.update') }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control form-control-lg
                                   @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control form-control-lg
                                   @error('email') is-invalid @enderror">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <hr class="my-4">


                        {{-- Password --}}
                        <h5 class="fw-bold mb-1">
                            Ganti Password
                        </h5>

                        <p class="text-muted small mb-3">
                            Kosongkan jika tidak ingin mengganti password.
                        </p>


                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg
                                   @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control form-control-lg"
                                   placeholder="Ulangi password baru">

                        </div>


                        <div class="d-flex justify-content-between">

                            <a href="{{ route('dashboard') }}"
                               class="btn btn-light border px-4">

                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali

                            </a>

                            <button type="submit"
                                    class="btn btn-primary px-4">

                                <i class="bi bi-check-lg me-1"></i>
                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>


<style>

.profile-card {
    border-radius: 18px;
}

.profile-avatar {
    width: 100px;
    height: 100px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: linear-gradient(
        135deg,
        #0d6efd,
        #6610f2
    );

    color: white;

    font-size: 42px;
    font-weight: 700;

    box-shadow: 0 8px 25px rgba(13, 110, 253, 0.25);
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 15px;

    padding: 12px 0;
}

.profile-info > i {
    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f1f5f9;

    color: #0d6efd;

    font-size: 18px;
}

.card {
    border-radius: 18px;
}

.form-control {
    border-radius: 10px;
}

.btn {
    border-radius: 10px;
}

</style>

@endsection