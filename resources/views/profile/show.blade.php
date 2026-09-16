@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header text-white border-0 py-4" style="background: linear-gradient(135deg, #111827 0%, #1f2937 45%, #0d6efd 100%);">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <div>
                            <p class="mb-1 text-uppercase small text-white-50">Identitas diri</p>
                            <h3 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Saya</h3>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold text-dark">
                            <i class="bi bi-pencil-square me-1"></i>Ubah Profil
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-4">
                            <div class="text-center p-4 rounded-4 border bg-light shadow-sm">
                                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow" style="width: 120px; height: 120px; background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); font-size: 3rem;">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <h4 class="mt-3 mb-1 text-dark">{{ $user->name }}</h4>
                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 fw-semibold">
                                    {{ ucfirst($user->role?->name ?? 'User') }}
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="border rounded-4 p-3 bg-light h-100">
                                        <small class="text-uppercase text-muted">Nama Lengkap</small>
                                        <h5 class="mb-0 mt-2 fw-bold text-dark">{{ $user->name }}</h5>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="border rounded-4 p-3 bg-light h-100">
                                        <small class="text-uppercase text-muted">Email</small>
                                        <h5 class="mb-0 mt-2 fw-bold text-dark">{{ $user->email }}</h5>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="border rounded-4 p-3 bg-light h-100">
                                        <small class="text-uppercase text-muted">Peran</small>
                                        <div class="mt-2">
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role?->name ?? 'User') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
