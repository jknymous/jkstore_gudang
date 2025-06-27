<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center text-xl font-semibold text-gray-800 leading-tight">
            Data Purchase
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="flex justify-end mb-4">
            <a href="{{ auth()->user()->role === 'admin' ? url('admin/purchase/create') : url('gudang/purchase/create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Purchase
            </a>
        </div>

        <div class="bg-white rounded shadow overflow-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Satuan</th>
                        <th class="px-4 py-2">Harga Beli</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $purchase->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $purchase->barang->nama_barang }}</td>
                            <td class="px-4 py-2">{{ $purchase->jumlah }}</td>
                            <td class="px-4 py-2">{{ $purchase->barang->satuan ?? '-' }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($purchase->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs 
                                    {{ 
                                        $purchase->status == 'selesai' ? 'bg-green-100 text-green-700' :
                                        ($purchase->status == 'retur' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') 
                                    }}">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex flex-wrap gap-1">
                                <a href="{{ url(request()->segment(1).'/purchase/'.$purchase->id.'/edit') }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ url(request()->segment(1).'/purchase/'.$purchase->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>

                                @if($purchase->status === 'pending')
                                    <form action="{{ url(request()->segment(1).'/purchase/'.$purchase->id.'/selesai') }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                                            Selesai
                                        </button>
                                    </form>
                                    <form action="{{ url(request()->segment(1).'/purchase/'.$purchase->id.'/retur') }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-2 py-1 rounded text-xs">
                                            Retur
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada data purchase</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
