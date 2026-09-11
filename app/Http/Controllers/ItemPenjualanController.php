<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemPenjualanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:produk,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $sale = Penjualan::where('user_id', Auth::id())
                ->where('status', 'OPEN')
                ->lockForUpdate()
                ->firstOrFail();

            $product = Produk::lockForUpdate()->findOrFail($validated['product_id']);
            $quantity = (int) $validated['quantity'];

            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            $newQuantity = ($item?->kuantitas ?? 0) + $quantity;

            if ($product->stok < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok {$product->nama} tidak mencukupi. Stok tersedia: {$product->stok}.",
                ]);
            }

            $product->decrement('stok', $quantity);

            if ($item) {
                $item->update([
                    'kuantitas' => $newQuantity,
                    'subtotal' => $newQuantity * $item->harga_satuan,
                ]);
            } else {
                $item = ItemPenjualan::create([
                    'penjualan_id' => $sale->id,
                    'produk_id' => $product->id,
                    'kuantitas' => $quantity,
                    'harga_satuan' => $product->harga_jual,
                    'subtotal' => $quantity * $product->harga_jual,
                ]);
            }

            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal'),
            ]);
        });

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $this->authorize('update', $itempenjualan);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated, $itempenjualan) {
            $itempenjualan->load('produk', 'penjualan');

            $produk = Produk::lockForUpdate()->findOrFail($itempenjualan->produk_id);
            $newQuantity = (int) $validated['quantity'];
            $difference = $newQuantity - $itempenjualan->kuantitas;

            if ($difference > 0 && $produk->stok < $difference) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok {$produk->nama} tidak mencukupi. Stok tersedia: {$produk->stok}.",
                ]);
            }

            if ($difference > 0) {
                $produk->decrement('stok', $difference);
            } elseif ($difference < 0) {
                $produk->increment('stok', abs($difference));
            }

            $itempenjualan->update([
                'kuantitas' => $newQuantity,
                'subtotal' => $newQuantity * $itempenjualan->harga_satuan,
            ]);

            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan
                    ->itemPenjualan()
                    ->sum('subtotal'),
            ]);
        });

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);

        DB::transaction(function () use ($itempenjualan) {
            $itempenjualan->load('produk', 'penjualan');

            $itempenjualan->produk?->increment('stok', $itempenjualan->kuantitas);

            $sale = $itempenjualan->penjualan;
            $itempenjualan->delete();

            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal'),
            ]);
        });

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
