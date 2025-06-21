<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Data Barang</h1>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <a href="{{ auth()->user()->role === 'admin' ? url('admin/barang/create') : url('gudang/barang/create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Barang
            </a>             
        </div>

        <div class="bg-white shadow rounded overflow-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Satuan</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2">Harga Beli</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $barang->nama_barang }}</td>
                            <td class="px-4 py-2">{{ $barang->satuan ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $barang->stok }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($barang->harga_beli ?? 0) }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ auth()->user()->role === 'admin' ? url("admin/barang/$barang->id/edit") : url("gudang/barang/$barang->id/edit") }}"> Edit </a>
                                <form action="{{ auth()->user()->role === 'admin' ? url("admin/barang/$barang->id") : url("gudang/barang/$barang->id") }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-4 text-center">Belum ada barang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
