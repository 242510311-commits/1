@extends('layouts.app')

@section('title', 'Login POS')

@section('content')
<div class="row justify-content-center align-items-center min-vh-75">
    <div class="col-sm-10 col-md-6 col-lg-4">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="display-6 text-primary mb-2">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h2 class="fw-bold mb-1">POS Rizal</h2>
                    <p class="text-muted mb-0">Silakan masuk untuk melanjutkan.</p>
                </div>

                <form action="{{ route('auth') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               autocomplete="email" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="current-password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
