<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SideLinkadmin extends Component
{
    public $href;

    public $active;

    public function __construct($href)
    {
        $this->href = $href;

        // Ambil nama route dari URL href
        $targetRoute = optional(Route::getRoutes()->match(request()->create($href)))->getName();

        // Ambil prefix utama route-nya (misal: admin.posts)
        $prefix = '';
        if ($targetRoute) {
            $parts = explode('.', $targetRoute);
            array_pop($parts); // buang bagian terakhir (index/edit/show)
            $prefix = implode('.', $parts);
        }

        // Cek aktif berdasarkan route sekarang
        $this->active = $prefix && request()->routeIs($prefix.'*');
    }

    public function render()
    {
        return view('components.side-linkadmin');
    }
}
