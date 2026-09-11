<?php

namespace Database\Seeders;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $products = Produk::all();

        if ($products->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($products) {
            Penjualan::factory()
                ->count(20)
                ->create()
                ->each(function (Penjualan $penjualan) use ($products) {
                    $selected = $products->random(min(3, $products->count()));
                    $total = 0;

                    foreach ($selected as $produk) {
                        $qty = min(random_int(1, 3), max(1, $produk->stok));
                        ItemPenjualan::create([
                            'penjualan_id' => $penjualan->id,
                            'produk_id' => $produk->id,
                            'kuantitas' => $qty,
                            'harga_satuan' => $produk->harga_jual,
                            'subtotal' => $produk->harga_jual * $qty,
                        ]);
                        $produk->decrement('stok', $qty);
                        $total += $produk->harga_jual * $qty;
                    }

                    $penjualan->update(['total_pembayaran' => $total]);
                });
        });
    }
}
