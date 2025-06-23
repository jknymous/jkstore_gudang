<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Tambah Stok Keluar</h1>
    
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    
        <form action="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}" method="POST">
            @csrf
    
            <div class="mb-4">
                <label for="barang_id" class="block font-medium">Pilih Barang</label>
                <select name="barang_id" id="barang_id" class="w-full border p-2 rounded">
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-4">
                <label for="toko_id" class="block font-medium">Pilih Toko</label>
                <select name="toko_id" id="toko_id" class="w-full border p-2 rounded">
                    @foreach($tokos as $toko)
                        <option value="{{ $toko->id }}">{{ $toko->nama_toko }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-4">
                <label for="jumlah" class="block font-medium">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full border p-2 rounded" required min="1">
            </div>
    
            <div class="mb-4">
                <label for="keterangan" class="block font-medium">Keterangan (opsional)</label>
                <textarea name="keterangan" id="keterangan" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>
    
            <div class="flex justify-end">
                <a href="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar') : url('gudang/stok-keluar') }}" class="bg-gray-200 px-4 py-2 rounded mr-2 hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
            </div>
        </form>
    </div>
</x-app-layout>