<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-xl font-semibold text-gray-800 leading-tight">
            Tambah Barang
        </h2>
    </x-slot>

    <div class="p-6 max-w-lg mx-auto bg-white shadow rounded">
        <form action="{{ auth()->user()->role === 'admin' ? url('admin/barang') : url('gudang/barang') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Satuan</label>
                <input type="text" name="satuan" class="w-full border px-3 py-2 rounded" placeholder="pcs / box">
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Stok Awal</label>
                <input type="number" name="stok" class="w-full border px-3 py-2 rounded" min="0" value="0">
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Harga Beli (Stok Awal)</label>
                <input type="number" name="harga_beli" class="w-full border px-3 py-2 rounded" min="0">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/barang') : url('gudang/barang') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
