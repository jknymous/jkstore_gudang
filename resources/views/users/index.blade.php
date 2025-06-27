<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Data User Gudang</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah User</a>

        <div class="mt-4">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('users.destroy', $user) }}">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-2">Belum ada user gudang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
