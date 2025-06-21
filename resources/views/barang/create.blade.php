<x-app-layout>
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Barang</h1>

        <form action="{{ auth()->user()->role === 'admin' ? url('admin/barang') : url('gudang/barang') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Satuan</label>
                <input type="text" name="satuan" class="w-full border px-3 py-2 rounded" placeholder="pcs / box">
            </div>

            <div>
                <label class="block mb-1 font-medium">Stok Awal</label>
                <input type="number" name="stok" class="w-full border px-3 py-2 rounded" min="0" value="0">
            </div>

            <div>
                <label class="block mb-1 font-medium">Harga Beli (Stok Awal)</label>
                <input type="number" name="harga_beli" class="w-full border px-3 py-2 rounded" min="0">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/barang') : url('gudang/barang') }}">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
