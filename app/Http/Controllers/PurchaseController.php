<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = \App\Models\Purchase::with('barang', 'user')->latest()->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangs = Barang::select('nama_barang', \DB::raw('MIN(id) as id'))
        ->groupBy('nama_barang')
        ->orderBy('nama_barang')
        ->get();

        return view('purchase.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga_beli' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);
    
        Purchase::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->to(auth()->user()->role === 'admin' ? 'admin/purchase' : 'gudang/purchase')
                        ->with('success', 'Data purchase berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('purchase.edit', compact('purchase', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga_beli' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);
    
        $purchase->update([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'keterangan' => $request->keterangan,
        ]);
    
        return redirect()->to(auth()->user()->role === 'admin' ? 'admin/purchase' : 'gudang/purchase')
                        ->with('success', 'Data purchase berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);

        // Jika statusnya selesai, kurangi stok barang
        if ($purchase->status === 'selesai') {
            $barang = Barang::find($purchase->barang_id);
            if ($barang) {
                $barang->stok = max(0, $barang->stok - $purchase->jumlah);
                $barang->save();
            }
        }
        $purchase->delete();
        return redirect()->back()->with('success', 'Data purchase berhasil dihapus.');
    }

    public function selesai(Purchase $purchase)
    {
        // Hanya bisa diproses jika masih pending
        if ($purchase->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses.');
        }

        // Cari apakah sudah ada barang dengan nama dan harga yang sama
        $existingBarang = Barang::where('nama_barang', $purchase->barang->nama_barang)
            ->where('harga_beli', $purchase->harga_beli)
            ->first();

        if ($existingBarang) {
            // Jika barang dengan harga sama ditemukan, tambah stok
            $existingBarang->stok += $purchase->jumlah;
            $existingBarang->save();
        } else {
            // Jika harga beda, buat barang baru (tanpa menambahkan "(new)")
            Barang::create([
                'nama_barang' => $purchase->barang->nama_barang,
                'satuan' => $purchase->satuan,
                'stok' => $purchase->jumlah,
                'harga_beli' => $purchase->harga_beli
            ]);
        }

        $purchase->status = 'selesai';
        $purchase->save();

        return redirect()->back()->with('success', 'Purchase telah diselesaikan.');
    }

    public function retur(Purchase $purchase)
    {
        // Hanya bisa diretur jika masih pending
        if ($purchase->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $purchase->status = 'retur';
        $purchase->save();

        return redirect()->back()->with('success', 'Purchase berhasil diretur.');
    }
}
