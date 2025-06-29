<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'nullable|string|max:20',
            'stok' => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|integer|min:0',
        ]);

        try {
            Barang::create([
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'stok' => $request->stok,
                'harga_beli' => $request->harga_beli,
            ]);

            return redirect()->to(auth()->user()->role === 'admin' ? '/admin/barang' : '/gudang/barang')
                             ->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menambahkan barang.');
        }
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'nullable|string|max:20',
            'stok' => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|integer|min:0',
        ]);

        try {
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'satuan' => $request->satuan,
                'stok' => $request->stok,
                'harga_beli' => $request->harga_beli,
            ]);

            return redirect()->to(auth()->user()->role === 'admin' ? '/admin/barang' : '/gudang/barang')
                             ->with('success', 'Barang berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupdate barang.');
        }
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect()->to(auth()->user()->role === 'admin' ? '/admin/barang' : '/gudang/barang')
                             ->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus barang.');
        }
    }
}
