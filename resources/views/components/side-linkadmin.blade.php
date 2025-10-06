@props(['href'])

@php
    $current = request()->path();          // contoh: admin/setting/users
    $target = trim(parse_url($href, PHP_URL_PATH), '/'); // contoh: admin/setting/profile

    // Ambil segmen awal sebelum halaman spesifik
    $base = collect(explode('/', $target))
                ->slice(0, 2)              // ambil "admin/setting"
                ->implode('/');

    $isActive = str_starts_with($current, $base);
@endphp

<a href="{{ $href }}"
   class="{{ $isActive
        ? 'bg-gray-900 text-indigo-600 font-bold'
        : 'text-white hover:bg-gray-700 hover:text-white' }}
        block px-3 py-2 rounded-md font-bold"
   aria-current="{{ $isActive ? 'page' : false }}">
    {{ $slot }}
</a>

<!-- <nav class="px-4 space-y-2">
    <a href="#" class="flex items-center px-4 py-2 text-indigo-600 bg-indigo-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
    </svg>
    <span class="font-semibold">Dashboard</span>
    </a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M17 20h5v-2a3 3 0 00-3-3h-4m-4 0H7a3 3 0 00-3 3v2h5m6-16a4 4 0 110 8 4 4 0 010-8z" />
    </svg>
    Team
    </a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M9 17v-6h6v6m-6 0h6M5 4v16h14V4H5z" />
    </svg>
    Projects
    </a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M8 7V3m8 4V3m-9 9h10m-12 5h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    Calendar
    </a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M12 20h9M12 4h9m-9 8h9m-18 4h.01M3 8h.01M3 16h.01M3 12h.01" />
    </svg>
    Documents
    </a>
    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
        <path d="M11 11V7a4 4 0 118 0v4a4 4 0 11-8 0zm1 4h6m-3 4v-4" />
    </svg>
    Reports
    </a>
</nav> -->