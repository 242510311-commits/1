<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use Illuminate\Http\Request;

class JenisProdukController extends Controller
{
    public function index()
    {
        $jenisProduk = JenisProduk::all();
        return view('jenis_produk.index', compact('jenisProduk'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_jenis' => 'required|string|max:255']);
        JenisProduk::create($request->only('nama_jenis'));

        return back()->with('success', 'Jenis produk berhasil ditambahkan!');
    }

    public function destroy(JenisProduk $jenisProduk)
    {
        $jenisProduk->delete();
        return back()->with('success', 'Jenis produk berhasil dihapus!');
    }
}