<x-layoutuser>
    <div class="max-w-4xl mx-auto py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-800 p-6 flex flex-col items-center text-white relative">
                <!-- Foto Profil -->
                <div class="relative" x-data="{ openPreview: false }">
                    <img src="{{ $user->profile_photo_url }}" 
                        alt="Profile Photo"
                        @click="openPreview = true"
                        class="w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover transition-transform duration-300 hover:scale-105 cursor-pointer">

                    <!-- Modal Preview -->
                    <div x-show="openPreview" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full 
                                    max-w-sm md:max-w-sm lg:max-w-sm mx-auto">

                            <!-- Foto Besar -->
                            <img src="{{ $user->profile_photo_url }}" 
                                alt="Profile Photo"
                                class="w-full h-full rounded-xl object-cover shadow">

                            <!-- Tombol Back -->
                            <button @click="openPreview = false"
                                    class="mt-5 w-full px-4 py-2 rounded-md bg-gray-800 text-white text-sm hover:bg-gray-900 transition">
                                Back
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Nama & Username -->
                <h1 class="mt-5 text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-indigo-200 text-sm tracking-wide"><b>@</b>{{ $user->username }}</p>
            </div>

            <!-- Body -->
            <div class="p-8 space-y-6">
                <!-- Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Joined</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $user->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Role</p>
                        <p class="text-lg font-medium text-gray-800 mt-1 capitalize">{{ $user->alias_role }}</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Likes</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $total_likes }}</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Articles</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $total_posts }}</p>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="p-6 border-t bg-gray-50 flex justify-end">
                <a href="{{ url()->previous() }}" 
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                   Back
                </a>
            </div>
        </div>
    </div>
</x-layoutuser>

