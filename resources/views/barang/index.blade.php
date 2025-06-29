<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-center text-gray-800">Data Barang</h2>
    </x-slot>

    <div class="py-6 px-8">
        <div class="flex justify-end mb-4">
            <a href="{{ auth()->user()->role === 'admin' ? url('admin/barang/create') : url('gudang/barang/create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Barang
            </a>             
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Satuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Harga Satuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr class="border-b">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $barang->stok }}</td>
                            <td class="px-6 py-4">{{ $barang->satuan ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($barang->harga_beli ?? 0) }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ auth()->user()->role === 'admin' ? url("admin/barang/$barang->id/edit") : url("gudang/barang/$barang->id/edit") }}" 
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L6 11.172V14h2.828l8.586-8.586a2 2 0 000-2.828z"/>
                                        <path fill-rule="evenodd" d="M4 16a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z" clip-rule="evenodd"/>
                                    </svg>
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ auth()->user()->role === 'admin' ? url("admin/barang/$barang->id") : url("gudang/barang/$barang->id") }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
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
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
