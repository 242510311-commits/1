<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = trim((string) $request->input('search'));

        $products = Produk::with('user')
            ->when($keyword !== '', fn ($query) =>
                $query->where('nama', 'like', "%{$keyword}%")
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);

        $data = $request->validated();
        $data = [
            'user_id' => Auth::id(),
            'nama' => $data['name'],
            'harga_beli' => $data['purchase_price'],
            'harga_jual' => $data['selling_price'],
            'stok' => $data['stock'],
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);

        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);

        return view('produk.edit', compact('produk'));
    }

    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $validated = $request->validated();

        $data = [
            'user_id' => Auth::id(),
            'nama' => $validated['name'],
            'harga_beli' => $validated['purchase_price'],
            'harga_jual' => $validated['selling_price'],
            'stok' => $validated['stock'],
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        if ($produk->itemPenjualan()->exists()) {
            return back()->with('errors', 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
