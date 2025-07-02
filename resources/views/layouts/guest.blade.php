<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JKStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .toggle-password {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex">
        <!-- Branding (Kiri) -->
        <div class="hidden lg:flex w-1/2 bg-white flex-col justify-center items-center shadow-lg">
            <div class="text-5xl font-bold text-blue-800 mb-4">JKStore</div>
            <p class="text-gray-600 text-center px-8 text-lg">
                Sistem Manajemen Gudang & Kasir yang modern dan efisien.
            </p>
        </div>

        <!-- Form Login (Kanan) -->
        <div class="flex-1 flex items-center justify-center px-6 py-12 bg-gray-100">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleIcons = document.querySelectorAll('.toggle-password');
            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function () {
                    const input = document.querySelector(`#${this.dataset.target}`);
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.innerHTML = eyeOff;
                    } else {
                        input.type = 'password';
                        this.innerHTML = eye;
                    }
                });
            });

            const eye = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            `;

            const eyeOff = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.965 9.965 0 013.122-4.568m3.52-2.077A9.99 9.99 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.964 9.964 0 01-1.507 2.549M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m0 0a3 3 0 01-3 3m-6 6l18-18"/>
                </svg>
            `;
        });
    </script>
</body>
</html>
