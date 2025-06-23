<?php

namespace App\Http\Controllers;

use App\Models\StokKeluar;
use App\Models\Barang;
use App\Models\Toko;
use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    public function index()
    {
        $data = StokKeluar::with('barang', 'toko', 'user')->latest()->get();
        return view('stok_keluar.index', compact('data'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $tokos = Toko::orderBy('nama_toko')->get();

        return view('stok_keluar.create', compact('barangs', 'tokos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'toko_id' => 'required|exists:tokos,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // Kurangi stok barang
        $barang->decrement('stok', $request->jumlah);

        // Simpan transaksi stok keluar
        StokKeluar::create([
            'barang_id' => $request->barang_id,
            'toko_id' => $request->toko_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('stok-keluar.index')->with('success', 'Stok berhasil dikirim');
    }
}
