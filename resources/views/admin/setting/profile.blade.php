<x-layoutadmin>
    <x-layoutsetting />

    {{-- Alerts --}}
    <x-alert-success />
    <x-alert-error />

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- === Update Photo === --}}
        <div class="rounded-2xl border p-6 bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition">
            <h3 class="mb-6 text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-user-circle text-indigo-500"></i> My Profile
            </h3>

            {{-- === Foto Sekarang dan Tombol Modal === --}}
            <div x-data="{ open: false }" class="flex items-center gap-5 mb-8">
                <!-- Foto Profil -->
                <div class="relative" x-data="{ openPreview: false }">
                    <img src="{{ Auth::user()->profile_photo_url }}" 
                        alt="Profile Photo"
                        @click="openPreview = true"
                        class="w-20 h-20 rounded-full object-cover border shadow-sm transition-transform duration-300 hover:scale-105 cursor-pointer">

                    <!-- Modal Preview -->
                    <div x-show="openPreview" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full 
                                    max-w-sm md:max-w-sm lg:max-w-sm mx-auto">

                            <!-- Foto Besar -->
                            <img src="{{ Auth::user()->profile_photo_url }}" 
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

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        Profile Photo
                    </label>

                    <button @click="open = true"
                            class="px-3 py-1 bg-indigo-600 border border-indigo-700 text-sm text-white rounded-md hover:bg-indigo-700 transition">
                        Change Photo
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="open" x-cloak
                     class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                    <div @click.away="open = false"
                         class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 mx-4">

                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Change Profile Photo</h2>

                        {{-- === FORM: Upload New Photo === --}}
                        <form action="{{ route('admin.setting.photo.update') }}" 
                              method="POST" enctype="multipart/form-data" class="">
                            @csrf
                            @method('PUT')

                            <div class="flex justify-center mb-2">
                                <img src="{{ Auth::user()->profile_photo_url }}" 
                                     id="preview" 
                                     class="w-24 h-24 rounded-full object-cover border shadow">
                            </div>

                            <div class="flex justify-center">
                                <label for="profile_photo" 
                                       class="px-2 py-1 text-xs rounded-md bg-green-600 text-white hover:bg-green-700 cursor-pointer">
                                    Select Photo
                                </label>
                            </div>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                   class="hidden" onchange="previewPhoto(event)">

                            <div class="flex justify-center gap-2 mt-6">
                                <button type="button" 
                                        @click="open = false"
                                        class="w-full px-4 py-2 text-sm rounded-md border bg-gray-100 text-gray-700 hover:bg-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                    Save Photo
                                </button>
                            </div>
                        </form>

                        {{-- === FORM: Delete Photo === --}}
                        @if (Auth::user()->profile_photo)
                            <form action="{{ route('admin.setting.photo.delete') }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete your profile photo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-3 py-2 text-sm rounded-md bg-red-600 text-white hover:bg-red-700 mt-2">
                                    Delete Photo
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <script>
                function previewPhoto(event) {
                    const output = document.getElementById('preview');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = () => URL.revokeObjectURL(output.src);
                }
            </script>

            {{-- === FORM: Update Profile === --}}
            <form method="POST" action="{{ route('admin.setting.profile.update') }}" class="space-y-5">
                @csrf
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Name</label>
                    <input name="name" type="text" 
                        value="{{ old('Auth::user()->name', Auth::user()->name) }}" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                {{-- Username --}}
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Username</label>
                    <input name="username" type="text" 
                        value="{{ old('Auth::user()->username', Auth::user()->username) }}" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Email</label>
                    <input name="email" type="email" 
                        value="{{ old('Auth::user()->email', Auth::user()->email) }}" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                {{-- Save Button --}}
                <div class="pt-3">
                    <button class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>

        {{-- === Update Password === --}}
        <form method="POST" action="{{ route('admin.setting.password.update') }}" 
              class="rounded-2xl border p-6 bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition">
            @csrf
            <h3 class="mb-6 text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                <i class="fas fa-lock text-indigo-500"></i> Change Password
            </h3>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Current Password</label>
                    <input name="current_password" type="password" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">New Password</label>
                    <input name="password" type="password" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Confirm New Password</label>
                    <input name="password_confirmation" type="password" 
                        class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div class="pt-3">
                    <button class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                        Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layoutadmin>