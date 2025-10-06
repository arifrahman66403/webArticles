<x-layoutuser>
    <div class="flex justify-center mt-10">
        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl border border-gray-200"
             x-data="{ openPhotoModal: false }">

            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Account Settings</h2>

            {{-- Alert --}}
            <x-alert-success />
            <x-alert-error />

            {{-- === BAGIAN FOTO PROFILE === --}}
            <div class="flex items-center gap-5 mb-8">
                {{-- Current Photo --}}
                <img src="{{ Auth::user()->profile_photo_url }}" 
                    class="w-20 h-20 rounded-full object-cover border shadow-sm" alt="Avatar">

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2 text-gray-700">
                        Profile Photo
                    </label>

                    <button @click="openPhotoModal = true"
                            class="px-3 py-1 bg-indigo-600 border border-indigo-700 text-sm text-white rounded-md hover:bg-indigo-700 transition">
                        Change Photo
                    </button>
                </div>
            </div>

            <!-- Modal Ubah Foto -->
            <div x-show="openPhotoModal" x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                <div @click.away="openPhotoModal = false"
                    class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 mx-4">

                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Change Profile Photo</h2>

                    {{-- === FORM: Upload New Photo === --}}
                    <form action="{{ route('user.photo.update') }}" 
                        method="POST" enctype="multipart/form-data" class="">
                        @csrf
                        @method('PUT')

                        {{-- Preview --}}
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

                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" 
                                    @click="openPhotoModal = false"
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
                        <form action="{{ route('user.photo.delete') }}" method="POST"
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

            {{-- === FORM UPDATE DATA AKUN === --}}
            <form action="{{ route('user.setting.update') }}" method="POST" class="mt-10">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none" required>
                </div>

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" 
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none" required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none" required>
                </div>

                <hr class="my-6">

                {{-- Current Password --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Current Password <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password"
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none"
                        placeholder="Enter the current password" required>
                    @error('current_password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">New Password <span class="text-gray-400">(Optional)</span></label>
                    <input type="password" name="password" 
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none">
                    @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-300 focus:outline-none">
                </div>

                {{-- Tombol --}}
                <div class="flex justify-between gap-3">
                    <a href="{{ route('user.profile', Auth::user()->username) }}" 
                       class="w-1/2 text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow">
                        View Profile
                    </a>
                    <button type="submit" 
                            class="w-1/2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewPhoto(event) {
            const output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</x-layoutuser>