<?php

namespace Database\Factories;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    protected $model = Penjualan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::whereHas('role', fn ($q) => $q->where('name', 'kasir'))
                ->inRandomOrder()->value('id') ?? User::query()->value('id'),
            'total_pembayaran' => 0,
            'metode_pembayaran' => 'CASH',
            'status' => 'COMPLETED',
        ];
    }
}
