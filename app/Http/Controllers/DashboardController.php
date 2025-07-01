<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Purchase;
use App\Models\StokKeluar;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // Total Toko dan User Gudang
        $totalToko = Toko::count();
        $totalUserGudang = User::where('role', 'gudang')->count();

        // Total jenis barang berdasarkan nama unik
        $totalJenisBarang = Barang::distinct('nama_barang')->count('nama_barang');

        // Stok paling sedikit dan paling banyak
        $stokMinimum = Barang::orderBy('stok')->first();
        $stokMaksimum = Barang::orderByDesc('stok')->first();

        // Ambil tanggal terbaru dari purchase yang selesai atau retur
        $tanggalTerbaru = Purchase::whereIn('status', ['selesai', 'retur'])->latest()->first()?->created_at->toDateString();

        // Total selesai dan retur pada tanggal terbaru
        $totalSelesaiRetur = Purchase::whereIn('status', ['selesai', 'retur'])
            ->whereDate('created_at', $tanggalTerbaru)
            ->count();

        // Total pending pada tanggal yang sama
        $totalPending = Purchase::where('status', 'pending')
            ->whereDate('created_at', $tanggalTerbaru)
            ->count();

        // Total barang keluar
        $totalStokKeluar = StokKeluar::count();

        // Total nilai semua stok yang ada di gudang
        $totalNilaiStok = Barang::sum(DB::raw('stok * harga_beli'));

        // Total nilai purchase yang baru selesai
        $totalNilaiSelesai = Purchase::where('status', 'selesai')
            ->whereDate('created_at', $tanggalTerbaru)
            ->sum(DB::raw('jumlah * harga_beli'));

        // Total nilai purchase yang masih pending
        $totalNilaiPending = Purchase::where('status', 'pending')
            ->whereDate('created_at', $tanggalTerbaru)
            ->sum(DB::raw('jumlah * harga_beli'));

        return view('dashboard.admin', compact(
            'totalToko',
            'totalUserGudang',
            'totalJenisBarang',
            'stokMinimum',
            'stokMaksimum',
            'totalSelesaiRetur',
            'totalPending',
            'totalStokKeluar',
            'totalNilaiStok',
            'totalNilaiSelesai',
            'totalNilaiPending',
            'tanggalTerbaru'
        ));
    }
}