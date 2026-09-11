<?php

namespace App\Providers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use App\Policies\ItemPenjualanPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ProdukPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Produk::class => ProdukPolicy::class,
        Penjualan::class => PenjualanPolicy::class,
        ItemPenjualan::class => ItemPenjualanPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        \Carbon\Carbon::setLocale('id');

        $this->registerPolicies();
    }
}
