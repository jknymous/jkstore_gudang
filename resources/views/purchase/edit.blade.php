<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Purchase') }}
        </h2>
    </x-slot>

    <div class="py-4 px-6 max-w-xl">
        <form action="{{ url(request()->segment(1).'/purchase/'.$purchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Barang</label>
                <select name="barang_id" class="w-full border rounded p-2">
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $purchase->barang_id == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" class="w-full border rounded p-2" value="{{ $purchase->jumlah }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Harga Beli</label>
                <input type="number" name="harga_beli" class="w-full border rounded p-2" value="{{ $purchase->harga_beli }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded p-2">{{ $purchase->keterangan }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
