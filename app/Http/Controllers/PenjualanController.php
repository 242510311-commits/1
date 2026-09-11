<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Penjualan::class);

        $user = Auth::user();
        $keyword = trim((string) $request->input('search'));

        $sales = Penjualan::with('user')
            ->when($user->hasRole('kasir'), fn ($query) =>
                $query->where('user_id', $user->id)
            )
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->whereHas('user', fn ($q) =>
                    $q->where('name', 'like', "%{$keyword}%")
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    public function create(SearchRequest $request)
    {
        $sale = Penjualan::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'OPEN'],
            ['total_pembayaran' => 0, 'metode_pembayaran' => 'CASH']
        );

        $this->authorize('update', $sale);

        $keyword = trim((string) $request->input('search'));

        $products = Produk::query()
            ->when($keyword !== '', fn ($query) =>
                $query->where('nama', 'like', "%{$keyword}%")
            )
            ->orderBy('nama')
            ->get();

        $sale->load('itemPenjualan.produk');

        return view('penjualan.pos', [
            'sale' => $sale,
            'products' => $products,
            'mode' => 'create',
        ]);
    }

    public function show(Penjualan $penjualan)
    {
        $this->authorize('view', $penjualan);

        $penjualan->load('user', 'itemPenjualan.produk');

        return view('penjualan.show', ['sale' => $penjualan]);
    }

    public function edit(Penjualan $penjualan)
    {
        $this->authorize('update', $penjualan);

        $penjualan->load('itemPenjualan.produk');
        $products = Produk::orderBy('nama')->get();

        return view('penjualan.pos', [
            'sale' => $penjualan,
            'products' => $products,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $this->authorize('update', $penjualan);

        $validated = $request->validate([
            'payment_method' => ['required', 'in:CASH,QRIS'],
        ]);

        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('errors', 'Keranjang masih kosong.');
        }

        DB::transaction(function () use ($penjualan, $validated) {
            $total = (int) $penjualan->itemPenjualan()->sum('subtotal');

            $penjualan->update([
                'metode_pembayaran' => $validated['payment_method'],
                'total_pembayaran' => $total,
                'status' => 'COMPLETED',
            ]);
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }

    public function destroy(Penjualan $penjualan)
    {
        $this->authorize('delete', $penjualan);

        DB::transaction(function () use ($penjualan) {
            $penjualan->load('itemPenjualan.produk');

            foreach ($penjualan->itemPenjualan as $item) {
                $item->produk?->increment('stok', $item->kuantitas);
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}
