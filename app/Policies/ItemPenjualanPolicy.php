<?php

namespace App\Policies;

use App\Models\ItemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{
    public function update(User $user, ItemPenjualan $itempenjualan): bool
    {
        $sale = $itempenjualan->penjualan;

        return $sale
            && $sale->status === 'OPEN'
            && ($user->hasRole('admin') || $sale->user_id === $user->id);
    }

    public function delete(User $user, ItemPenjualan $itempenjualan): bool
    {
        return $this->update($user, $itempenjualan);
    }
}
