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

        return redirect()->to(auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar'))
                                    ->with('success', 'Purchase berhasil diupdate.');
    }

    public function edit($id)
    {
        $stokKeluar = StokKeluar::findOrFail($id);
        $barangs = Barang::all();
        $tokos = Toko::all();
        return view('stok_keluar.edit', compact('stokKeluar', 'barangs', 'tokos'));
    }

    public function update(Request $request, $id)
    {
        $stokKeluar = StokKeluar::findOrFail($id);
        $request->validate([
            'barang_id' => 'required',
            'toko_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        // Kembalikan stok lama
        $stokLama = $stokKeluar->jumlah;
        $barangLama = Barang::find($stokKeluar->barang_id);
        $barangLama->stok += $stokLama;
        $barangLama->save();

        // Update data
        $stokKeluar->update([
            'barang_id' => $request->barang_id,
            'toko_id' => $request->toko_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok baru
        $barangBaru = Barang::find($request->barang_id);
        $barangBaru->stok -= $request->jumlah;
        $barangBaru->save();

        return redirect()->to(auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar'))
                                    ->with('success', 'Purchase berhasil diupdate.');
    }

    public function destroy($id)
    {
        $stokKeluar = StokKeluar::findOrFail($id);
        $barang = Barang::find($stokKeluar->barang_id);

        // Kembalikan stok
        $barang->stok += $stokKeluar->jumlah;
        $barang->save();
        $stokKeluar->delete();
        return redirect()->to(auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar'))
                                    ->with('success', 'Purchase berhasil diupdate.');
    }
}
