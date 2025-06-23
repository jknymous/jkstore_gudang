<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">History Stok Keluar</h1>
        <a href="{{ auth()->user()->role === 'admin' ? url('admin/stok-keluar/create') : url('gudang/stok-keluar/create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Stok Keluar
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Barang</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Toko Tujuan</th>
                    <th class="p-2 border">Keterangan</th>
                    <th class="p-2 border">Dikirim Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr class="border-b">
                        <td class="p-2 border">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="p-2 border">{{ $item->barang->nama_barang }}</td>
                        <td class="p-2 border">{{ $item->jumlah }}</td>
                        <td class="p-2 border">{{ $item->toko->nama_toko }}</td>
                        <td class="p-2 border">{{ $item->keterangan ?? '-' }}</td>
                        <td class="p-2 border">{{ $item->user->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</x-app-layout>

