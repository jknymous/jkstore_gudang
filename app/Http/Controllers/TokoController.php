<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::latest()->get();
        return view('toko.index', compact('tokos'));
    }

    public function create()
    {
        return view('toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required',
        ]);

        try {
            Toko::create($request->only('nama_toko'));
            return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan toko.');
        }
    }

    public function edit(Toko $toko)
    {
        return view('toko.edit', compact('toko'));
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'nama_toko' => 'required',
        ]);

        try {
            $toko->update($request->only('nama_toko'));
            return redirect()->route('toko.index')->with('success', 'Toko berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui toko.');
        }
    }

    public function destroy(Toko $toko)
    {
        try {
            $toko->delete();
            return redirect()->route('toko.index')->with('success', 'Toko berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('toko.index')->with('error', 'Gagal menghapus toko.');
        }
    }
}
