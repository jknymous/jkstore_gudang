<x-app-layout>
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
</x-app-layout>
