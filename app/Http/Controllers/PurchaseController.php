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
    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        $oldJumlah = $purchase->jumlah;
        $oldBarang = Barang::where('nama_barang', $purchase->barang->nama_barang)
                            ->where('harga_beli', $purchase->harga_beli)
                            ->first();
        // Jika status selesai, kurangi dulu stok dari barang lama
        if ($purchase->status === 'selesai' && $oldBarang) {
            $oldBarang->stok -= $oldJumlah;
            $oldBarang->save();
        }
        $purchase->update($request->only(['barang_id', 'jumlah', 'satuan', 'harga_beli', 'keterangan']));
        // Kalau status selesai, tambahkan ke barang baru
        if ($purchase->status === 'selesai') {
            $newBarang = Barang::where('nama_barang', $purchase->barang->nama_barang)
                                ->where('harga_beli', $purchase->harga_beli)
                                ->first();
            if ($newBarang) {
                $newBarang->stok += $purchase->jumlah;
            } else {
                $newBarang = Barang::create([
                    'nama_barang' => $purchase->barang->nama_barang,
                    'satuan' => $purchase->satuan,
                    'stok' => $purchase->jumlah,
                    'harga_beli' => $purchase->harga_beli,
                ]);
            }
            $newBarang->save();
            $purchase->barang_id = $newBarang->id;
            $purchase->save();
        }
        return redirect()->to(auth()->user()->role === 'admin' ? url('admin/purchase') : url('gudang/purchase'))
                                    ->with('success', 'Purchase berhasil diupdate.');
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
        if ($purchase->status === 'selesai') {
            $barang = Barang::where('nama_barang', $purchase->barang->nama_barang)
                            ->where('harga_beli', $purchase->harga_beli)
                            ->first();
            if ($barang) {
                $barang->stok -= $purchase->jumlah;
                $barang->save();
            }
        }
        $purchase->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function selesai($id)
    {
        $purchase = Purchase::findOrFail($id);
        if ($purchase->status !== 'pending') {
            return back()->with('error', 'Purchase sudah diproses.');
        }

        $namaBarang = $purchase->barang->nama_barang;
        $hargaBeli = $purchase->harga_beli;

        // 1. Cari barang dengan nama sama dan harga sama
        $barang = Barang::where('nama_barang', $namaBarang)
                        ->where('harga_beli', $hargaBeli)
                        ->first();

        if ($barang) {
            // Harga sama → tambah stok
            $barang->stok += $purchase->jumlah;
            $barang->save();
            $purchase->barang_id = $barang->id;
        } else {
            // 2. Cek barang stok 0 dengan nama sama
            $stokKosong = Barang::where('nama_barang', $namaBarang)
                                ->where('stok', 0)
                                ->first();

            if ($stokKosong) {
                // Ganti harga & stok
                $stokKosong->harga_beli = $hargaBeli;
                $stokKosong->satuan = $purchase->satuan;
                $stokKosong->stok = $purchase->jumlah;
                $stokKosong->save();
                $purchase->barang_id = $stokKosong->id;
            } else {
                // 3. Buat barang baru
                $barangBaru = Barang::create([
                    'nama_barang' => $namaBarang,
                    'satuan' => $purchase->satuan,
                    'stok' => $purchase->jumlah,
                    'harga_beli' => $hargaBeli,
                ]);
                $purchase->barang_id = $barangBaru->id;
            }
        }

        $purchase->status = 'selesai';
        $purchase->save();
        return redirect()->back()->with('success', 'Purchase berhasil diselesaikan.');
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
