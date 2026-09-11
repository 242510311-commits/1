<?php

namespace App\Policies;

use App\Models\Produk;
use App\Models\User;

class ProdukPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'kasir']);
    }

    public function view(User $user, Produk $produk): bool
    {
        return $user->hasAnyRole(['admin', 'kasir']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Produk $produk): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Produk $produk): bool
    {
        return $user->hasRole('admin');
    }
}
