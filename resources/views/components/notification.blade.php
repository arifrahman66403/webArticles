@guest
<div 
    x-data="{ open: localStorage.getItem('dismissedGuestNotif') !== 'true' }"
    x-show="open"
    x-transition
    class="relative flex items-center justify-between gap-x-6 bg-gray-100 border border-gray-300 px-4 py-2.5 sm:px-6 shadow-sm"
>
    <!-- Isi notif -->
    <div class="flex flex-wrap items-center gap-x-3 gap-y-2">
        <p class="text-sm text-gray-800">
            <strong class="font-semibold">Welcome!</strong>
            <svg viewBox="0 0 2 2" aria-hidden="true" class="mx-2 inline size-0.5 fill-current text-gray-500">
                <circle r="1" cx="1" cy="1" />
            </svg>
            Please <a 
                href="{{ route('login') }}" 
                @click="localStorage.setItem('dismissedGuestNotif', 'true')"
                class="hover:underline"
            >
            Login
            </a> or <a 
                href="{{ route('register') }}" 
                @click="localStorage.setItem('dismissedGuestNotif', 'true')"
                class="hover:underline"
            >
            Register
            </a> to enjoy all features.
        </p>
    </div>

    <!-- Tombol tutup -->
    <button 
        @click="open = false; localStorage.setItem('dismissedGuestNotif', 'true')" 
        type="button" 
        class="-m-2 p-2 text-gray-500 hover:text-gray-700"
    >
        <span class="sr-only">Dismiss</span>
        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
        </svg>
    </button>
</div>
@endguest

@auth
<script>
    // Hapus penanda kalau user login agar muncul lagi setelah logout
    localStorage.removeItem('dismissedGuestNotif');
</script>
@endauth