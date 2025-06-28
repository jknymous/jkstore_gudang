<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            Edit Stok Keluar
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-xl mx-auto bg-white rounded shadow">
        <form method="POST" action="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar/'.$stokKeluar->id) : url('gudang/stok-keluar/'.$stokKeluar->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Barang</label>
                <select name="barang_id" class="w-full border rounded p-2" required>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $stokKeluar->barang_id == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Toko Tujuan</label>
                <select name="toko_id" class="w-full border rounded p-2" required>
                    @foreach ($tokos as $toko)
                        <option value="{{ $toko->id }}" {{ $stokKeluar->toko_id == $toko->id ? 'selected' : '' }}>
                            {{ $toko->nama_toko }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border rounded p-2" required min="1" value="{{ $stokKeluar->jumlah }}">
            </div>

            <div class="flex justify-end">
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
