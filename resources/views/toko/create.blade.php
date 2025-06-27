{{-- <x-app-layout>
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Toko</h1>

        <form action="{{ route('toko.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama Toko</label>
                <input type="text" name="nama_toko" required class="w-full border px-3 py-2 rounded" value="{{ old('nama_toko') }}">
            </div>

            <div>
                <label class="block mb-1 font-medium">Alamat</label>
                <textarea name="alamat" class="w-full border px-3 py-2 rounded">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">No. Telepon</label>
                <input type="text" name="no_telepon" class="w-full border px-3 py-2 rounded" value="{{ old('no_telepon') }}">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ route('toko.index') }}" class="text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout> --}}


<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Toko') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-2xl mx-auto bg-white rounded shadow">
        <form action="{{ route('toko.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Toko</label>
                <input type="text" name="nama_toko" class="w-full border rounded p-2" value="{{ old('nama_toko') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="no_telepon" class="w-full border rounded p-2" value="{{ old('no_telepon') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2" rows="3">{{ old('alamat') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('toko.index') }}" class="px-4 py-2 mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>

