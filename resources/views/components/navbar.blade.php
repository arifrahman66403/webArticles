<nav class="bg-gray-800 fixed top-0 w-full z-50" x-data="{ isOpen: false }">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="flex items-center">
        <div class="shrink-0">
          <img class="size-8" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <!-- <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link> -->
            <x-nav-link href="/home" :activeWhen="['home','author/posts']">Home</x-nav-link>
            <x-nav-link href="/posts">Blog</x-nav-link>
            <x-nav-link href="/about">About</x-nav-link>
            <x-nav-link href="/contact">Contact</x-nav-link>
            @auth
              <x-nav-link href="{{ route('library.likes') }}" :activeWhen="['library']">Library</x-nav-link>
            @endauth
            @guest
              <x-nav-link href="/login">Login</x-nav-link>
            @endguest
        </div>
        </div>
      </div>
      <div class="hidden md:block">
        <div class="ml-4 flex items-center md:ml-6">

          <!-- Profile dropdown -->
          @if(Auth::user())
          <div class="relative ml-3">
            <div>
              <button type="button" @click="isOpen = !isOpen" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 hover:ring-2 hover:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full object-cover cursor-pointer" src="{{ Auth::user()->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode(Auth::user()->id) }}" alt="Profile Photo" />
              </button>
            </div>

            <div  x-show="isOpen"
                  x-transition:enter="transition ease-out duration-100 transform"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-75 transform"
                  x-transition:leave-start="opacity-100 scale-100"
                  x-transition:leave-end="opacity-0 scale-95"
                  class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
              <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">My Profile</a>
              <a href="{{ route('user.setting') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Setting</a>
              <form method="GET" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to log out?')">
              @csrf
              <button type="submit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Logout</button>
              </form>
            </div>
          </div>
          @endif
        </div>
      </div>

      <div class="-mr-2 flex md:hidden">
        <!-- Mobile menu button -->
        <button @click="isOpen = !isOpen" type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" aria-controls="mobile-menu" aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <!-- Menu open: "hidden", Menu closed: "block" -->
          <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
          <!-- Menu open: "block", Menu closed: "hidden" -->
          <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- Mobile menu, show/hide based on menu state. -->
  <div x-show="isOpen" class="md:hidden" id="mobile-menu">
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <x-nav-link href="/home" :activeWhen="['home','author/posts']">Home</x-nav-link>
      <x-nav-link href="/posts">Blog</x-nav-link>
      <x-nav-link href="/about">About</x-nav-link>
      <x-nav-link href="/contact">Contact</x-nav-link>
      @auth
        <x-nav-link href="{{ route('library.likes') }}" :activeWhen="['library']">Library</x-nav-link>
      @endauth
      @guest
        <x-nav-link href="/login">Login</x-nav-link>
      @endguest
    </div>
    @if(Auth::user())
    <div class="border-t border-gray-700 pt-4 pb-3">
      <div class="flex items-center px-5">
        <div class="shrink-0">
          <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode(Auth::user()->id) }}" alt="" />
        </div>
        <div class="ml-3">
          <div class="text-base/5 font-medium text-white">{{ Auth::user()->name }}</div>
          <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
        </div>
      </div>
      <div class="mt-3 space-y-1 px-2">
        <a href="{{ route('user.profile') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">My Profile</a>
        <a href="{{ route('user.setting') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Setting</a>
        <form method="GET" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to log out?')">
          @csrf
          <button type="submit" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Logout</button>
        </form>
      </div>
    </div>
    @endif
  </div>
  <x-notification />
</nav>