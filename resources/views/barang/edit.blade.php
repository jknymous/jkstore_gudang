<x-app-layout>
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Barang</h1>

        <form action="{{ auth()->user()->role === 'admin' ? url("admin/barang/$barang->id") : url("gudang/barang/$barang->id") }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border px-3 py-2 rounded" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Satuan</label>
                <input type="text" name="satuan" class="w-full border px-3 py-2 rounded" value="{{ old('satuan', $barang->satuan) }}">
            </div>

            <div>
                <label class="block mb-1 font-medium">Stok</label>
                <input type="number" name="stok" class="w-full border px-3 py-2 rounded" min="0" value="{{ old('stok', $barang->stok) }}">
            </div>

            <div>
                <label class="block mb-1 font-medium">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full border px-3 py-2 rounded" min="0" value="{{ old('harga_beli', $barang->harga_beli) }}">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/barang') : url('gudang/barang') }}">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
