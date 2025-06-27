<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Toko') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-2xl mx-auto bg-white rounded shadow">
        <form action="{{ route('toko.update', $toko->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Toko</label>
                <input type="text" name="nama_toko" class="w-full border rounded p-2" value="{{ old('nama_toko', $toko->nama_toko) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2" rows="3">{{ old('alamat', $toko->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="no_telepon" class="w-full border rounded p-2" value="{{ old('no_telepon', $toko->no_telepon) }}">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('toko.index') }}" class="px-4 py-2 mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
