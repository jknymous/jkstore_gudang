{{-- <x-app-layout>
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
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <div class="text-center text-xl font-semibold text-gray-800">
            Data Toko
        </div>
    </x-slot>

    <div class="py-6 px-8">
        <div class="flex justify-end mb-4">
            <a href="{{ route('toko.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Toko
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nomor Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tokos as $toko)
                        <tr>
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $toko->nama_toko }}</td>
                            <td class="px-6 py-4">{{ $toko->no_telepon }}</td>
                            <td class="px-6 py-4">{{ $toko->alamat }}</td>
                            <td class="px-6 py-4 space-x-2 flex">
                                <a href="{{ route('toko.edit', $toko->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L6 11.172V14h2.828l8.586-8.586a2 2 0 000-2.828z"/>
                                        <path fill-rule="evenodd" d="M4 16a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z" clip-rule="evenodd"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('toko.destroy', $toko->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3.5a.5.5 0 000 1H4v11a2 2 0 002 2h8a2 2 0 002-2V5h.5a.5.5 0 000-1H15V3a1 1 0 00-1-1H6zm2 5a.5.5 0 011 0v7a.5.5 0 01-1 0V7zm4 0a.5.5 0 011 0v7a.5.5 0 01-1 0V7z" clip-rule="evenodd"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data toko.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

