<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanService
{
    public function ringkasanHariIni(): array
    {
        $data = DB::table('penjualan')
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED')
            ->selectRaw('
                COUNT(*) AS total_transaksi,
                COALESCE(SUM(total_pembayaran), 0) AS total_penjualan,
                COALESCE(SUM(CASE WHEN metode_pembayaran = ? THEN total_pembayaran ELSE 0 END), 0) AS total_cash,
                COALESCE(SUM(CASE WHEN metode_pembayaran <> ? THEN total_pembayaran ELSE 0 END), 0) AS total_non_tunai
            ', ['CASH', 'CASH'])
            ->first();

        return [
            'total_transaksi' => (int) ($data->total_transaksi ?? 0),
            'total_penjualan' => (int) ($data->total_penjualan ?? 0),
            'total_cash' => (int) ($data->total_cash ?? 0),
            'total_non_tunai' => (int) ($data->total_non_tunai ?? 0),
        ];
    }

    public function produkTerlarisHariIni(int $limit = 5)
    {
        return DB::table('item_penjualan')
            ->join('penjualan', 'penjualan.id', '=', 'item_penjualan.penjualan_id')
            ->join('produk', 'produk.id', '=', 'item_penjualan.produk_id')
            ->whereDate('penjualan.created_at', Carbon::today())
            ->where('penjualan.status', 'COMPLETED')
            ->groupBy('produk.id', 'produk.nama', 'produk.stok')
            ->select(
                'produk.nama',
                'produk.stok',
                DB::raw('SUM(item_penjualan.kuantitas) AS total_terjual')
            )
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}
