<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ auth()->user()->isAdmin ? url('admin/profile') : url('gudang/profile') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Password Baru</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded p-2">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded p-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
