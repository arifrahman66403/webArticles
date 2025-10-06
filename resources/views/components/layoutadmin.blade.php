<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-script/>
    <title>Welcome {{ Auth::user()->name }}</title>
    <link rel="icon" type="image/jpg" href="{{ asset('favicon.jpg') }}">
    @livewireStyles
</head>
<body>
    <!-- x-data di sini biar state isOpen bisa dipakai di semua komponen -->
    <div class="flex h-screen" x-data="{ isOpen: false }">
        
        <!-- Sidebar -->
        <x-sidebaradmin />

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col">
            <x-headeradmin />

            <main class="flex-1 p-6 md:ml-64">
                {{ $slot }}
            </main>
        </div>

        <!-- Overlay untuk mobile -->
        <div 
            x-show="isOpen" 
            @click="isOpen = false" 
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
            x-transition.opacity
        ></div>
    </div>
    {{-- Tambahkan ini --}}
    @livewireScripts
    {{-- Jika ada script tambahan di halaman tertentu --}}
    @stack('scripts')
    {{-- Script untuk menangani event notifikasi --}}
    <script>
        Livewire.on('notify', (data) => {
            document.dispatchEvent(new CustomEvent('flash-message', { detail: data }));
        });
    </script>
</body>
</html>
