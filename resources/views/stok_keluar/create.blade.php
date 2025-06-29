<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            Tambah Stok Keluar
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-xl mx-auto bg-white rounded shadow">
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="barang_id" class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                <select name="barang_id" id="barang_id" class="w-full border p-2 rounded" required>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }} - Rp{{ number_format($barang->harga_beli, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="toko_id" class="block text-sm font-medium text-gray-700">Pilih Toko</label>
                <select name="toko_id" id="toko_id" class="w-full border p-2 rounded" required>
                    @foreach($tokos as $toko)
                        <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full border p-2 rounded" required min="1">
            </div>

            <div class="flex justify-end">
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
            </div>
        </form>
    </div>
</x-app-layout>
