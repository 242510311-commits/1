<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'kasir']);
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        return $user->hasRole('admin') || $penjualan->user_id === $user->id;
    }

    public function update(User $user, Penjualan $penjualan): bool
    {
        return $penjualan->status === 'OPEN'
            && ($user->hasRole('admin') || $penjualan->user_id === $user->id);
    }

    public function delete(User $user, Penjualan $penjualan): bool
    {
        return $penjualan->status === 'OPEN'
            && ($user->hasRole('admin') || $penjualan->user_id === $user->id);
    }
}
