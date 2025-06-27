<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Tambah User Gudang</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block">Nama</label>
                <input name="name" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
