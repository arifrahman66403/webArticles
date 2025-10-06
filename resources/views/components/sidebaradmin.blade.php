<aside 
    class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out z-50
           md:translate-x-0 md:flex-shrink-0"
    :class="{'-translate-x-full': !isOpen, 'translate-x-0': isOpen}"
>
    <!-- Header Sidebar (mobile only) -->
    <div class="p-4 border-b border-gray-700 flex justify-between items-center md:hidden">
        <h2 class="text-lg font-bold">Menu</h2>
        <button @click="isOpen = false" class="text-gray-300 hover:text-white">
            ✕
        </button>
    </div>

    <!-- Menu -->
    <div class="p-8 text-3xl">
        <h1 class="text-white font-bold relative transition-transform duration-500 hover:scale-110 hover:text-indigo-600">Admin Panel</h1>
    </div>
    <nav class="p-4 space-y-2">
        <x-side-linkadmin href="/home">Home</x-side-linkadmin>
        <x-side-linkadmin :href="route('admin.posts.index')">Posts</x-side-linkadmin>
        <x-side-linkadmin :href="route('message.index')">
            Message
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="px-3.5 py-0.5 mt-0.5 rounded-full text-xs bg-red-600 text-white float-right">
                    <p class="font-bold hover:-scale-100">{{ $unreadCount }}</p>
                </span>
            @endif
        </x-side-linkadmin>
        <x-side-linkadmin :href="route('admin.setting.profile.index')">Settings</x-side-linkadmin>
        <form method="GET" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to log out?')">
            @csrf
            <button type="submit" class="block px-3 py-2 rounded-md font-bold hover:bg-gray-700 hover:bg-red-700">
                Logout
            </button>
        </form>
    </nav>
</aside>
