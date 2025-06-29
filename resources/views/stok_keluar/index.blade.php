<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            Data Stok Keluar
        </h2>
    </x-slot>

    <div class="py-6 px-8">
        <div class="flex justify-end mb-4">
            <a href="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar/create') : url('gudang/stok-keluar/create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Stok Keluar
            </a>
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Toko Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dikirim Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $item->barang->nama_barang }}</td>
                            <td class="px-6 py-4">{{ $item->jumlah }}</td>
                            <td class="px-6 py-4">{{ $item->toko->nama_toko }}</td>
                            <td class="px-6 py-4">{{ $item->user->name }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ url(request()->segment(1).'/stok-keluar/'.$item->id.'/edit') }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L6 11.172V14h2.828l8.586-8.586a2 2 0 000-2.828z"/>
                                        <path fill-rule="evenodd" d="M4 16a2 2 0 002 2h8a2 2 0 002-2v-2H4v2z" clip-rule="evenodd"/>
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ url(request()->segment(1).'/stok-keluar/'.$item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3.5a.5.5 0 000 1H4v11a2 2 0 002 2h8a2 2 0 002-2V5h.5a.5.5 0 000-1H15V3a1 1 0 00-1-1H6zm2 5a.5.5 0 011 0v7a.5.5 0 01-1 0V7zm4 0a.5.5 0 011 0v7a.5.5 0 01-1 0V7z" clip-rule="evenodd"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4 text-gray-500">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>