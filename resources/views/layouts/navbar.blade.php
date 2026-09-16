<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('about') }}">
            <i class="bi bi-shop"></i> POS Rizal
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Buka navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}"
                       href="{{ route('produk.index') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jenis-produk.*') ? 'active' : '' }}"
                       href="{{ route('jenis-produk.index') }}">Jenis Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}"
                       href="{{ route('penjualan.index') }}">Penjualan</a>
                </li>
                @if(auth()->user()?->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                @endif
            </ul>

            @auth
            <div class="d-flex align-items-center gap-2">
    <div class="dropdown">
        <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center gap-2" 
                type="button" id="userProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <span>{{ auth()->user()->name ?? 'User Test' }}</span>
            <span class="badge text-bg-secondary">
                {{ ucfirst(auth()->user()->role?->name ?? 'User') }}
            </span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userProfileDropdown">
            <li>
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                    <i class="bi bi-person-circle me-2"></i> Profil Saya
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-gear me-2"></i> Edit Profil Saya
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
            @endauth
        </div>
    </div>
</nav>