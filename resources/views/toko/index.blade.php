<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Data Toko</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('toko.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Toko</a>
        </div>

        <div class="bg-white shadow rounded">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Nama Toko</th>
                        <th class="px-4 py-2">Alamat</th>
                        <th class="px-4 py-2">No. Telepon</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tokos as $toko)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $toko->nama_toko }}</td>
                            <td class="px-4 py-2">{{ $toko->alamat }}</td>
                            <td class="px-4 py-2">{{ $toko->no_telepon }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('toko.edit', $toko) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('toko.destroy', $toko) }}" method="POST" onsubmit="return confirm('Yakin hapus toko ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-4 py-4" colspan="4">Belum ada toko.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
