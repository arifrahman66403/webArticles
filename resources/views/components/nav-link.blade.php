@props(['active' => false, 'href', 'activeWhen' => []])

@php
    // Normalisasi semua pattern
    $activePatterns = collect((array) $activeWhen)
        ->map(fn($p) => trim($p, '/').'*')
        ->toArray();

    // Tambahkan juga pattern dari href
    $activePatterns[] = trim($href, '/').'*';

    // Cek apakah path saat ini cocok salah satu pattern
    $currentPath = request()->path();
    $autoActive = collect($activePatterns)->contains(function ($pattern) use ($currentPath) {
        return \Str::is($pattern, $currentPath);
    });

    $isActive = $active || $autoActive;
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' =>
        ($isActive
            ? 'bg-gray-900 text-white'
            : 'text-gray-300 hover:bg-gray-700 hover:text-white'
        ) .
        ' rounded-md px-3 py-2 text-sm font-medium'
    ]) }}
   aria-current="{{ $isActive ? 'page' : false }}">
    {{ $slot }}
</a>