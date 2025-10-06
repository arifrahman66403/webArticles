<x-layoutadmin>
    <x-layoutsetting />

    {{-- Alerts --}}
    <x-alert-success />
    <x-alert-error />

    {{-- === USER === --}}
    {{-- Form tambah user (collapsible) --}}
    <div x-data="{ open: false }" class="rounded-xl border bg-white dark:bg-gray-800 shadow-md mb-6">
        <div class="flex justify-between items-center p-4 dark:border-gray-700">
            <h3 class="text-lg font-semibold">Add User</h3>
            <button type="button"
                @click="open = !open"
                class="mr-2 text-xl transition-transform duration-300 hover:scale-110">
                <span x-text="open ? '✕' : '☰'"></span>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.setting.users.store') }}"
            x-show="open"
            x-transition
            class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input id="name" name="name" type="text" placeholder="Full name"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" 
                    oninput="document.getElementById('username').value = this.value.toLowerCase().replace(/\s+/g, '.')"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input id="username" name="username" type="text" placeholder="Username"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" type="email" placeholder="Email address"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                    <option value="user" selected>User</option>
                    <option value="author">Author</option>
                    @if (auth()->user()->isSuperAdmin())
                    <option value="admin">Admin</option>
                    @endif
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input name="password" type="password" placeholder="Password"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input name="password_confirmation" type="password" placeholder="Confirm password"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="pt-2">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                    Add user
                </button>
            </div>
        </form>
    </div>

    {{-- List User --}}
    <div class="rounded-xl border bg-white dark:bg-gray-800 shadow-md">
        <div class="px-5 py-3 border-b dark:border-gray-700 font-semibold flex justify-between items-center">
            <span>All Users <span class="text-sm text-gray-500">({{ $users->count() }} users)</span></span>
            <form class="flex gap-2 items-center" method="GET" action="{{ route('admin.setting.users.index') }}">
                <select name="role" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ request('role') === 'author' ? 'selected' : '' }}>Author</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search users..."
                    class="px-2 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
            </form>
        </div>
        <ul class="divide-y dark:divide-gray-700">
            @forelse($users as $user)
                <li class="px-5 py-3 flex justify-between items-center" x-data="{ edit:false }">

                    <div class="flex items-center gap-2">
                        <span>
                            <!-- Foto Profil -->
                            <div class="relative" x-data="{ openPreview: false }">
                                <img src="{{ $user->profile_photo_url }}" 
                                    alt="Profile Photo"
                                    @click="openPreview = true"
                                    class="w-8 h-8 rounded-full object-cover cursor-pointer">

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
                                        <div class="flex gap-2 mt-6">
                                        @if ($user->profile_photo)
                                            @can ('delete', $user)
                                                <form action="{{ route('admin.setting.users.photo.delete', $user) }}" method="POST"
                                                    onsubmit="return confirm('Delete this profile photo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="w-full px-4 py-2 text-sm rounded-md bg-red-600 text-white hover:bg-red-700">
                                                        Delete Photo
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif
                                        <button @click="openPreview = false"
                                                class="w-full px-4 py-2 text-sm rounded-md bg-gray-800 text-white hover:bg-gray-900">
                                            Back
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                        <span>{{ $user->name }} ({{ $user->username }}) - <span class="italic">{{ $user->role }}</span></span>
                    </div>

                    <div class="flex gap-2">
                        @can('update', $user)
                        <button @click="edit=true" class="px-3 py-1 rounded-md border">Edit</button>
                        @endcan
                        @can('delete', $user)
                        <form method="POST" action="{{ route('admin.setting.users.destroy', $user) }}" onsubmit="return confirm('Are you sure to delete {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 rounded-md bg-red-600 text-white">Delete</button>
                        </form>
                        @endcan
                    </div>

                    {{-- Modal Edit --}}
                    <div x-show="edit"
                        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">

                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-lg mx-4">
                            <h2 class="text-lg font-semibold mb-4">Edit User</h2>
                            <form method="POST" action="{{ route('admin.setting.users.update', $user->username) }}" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium">Name</label>
                                    <input type="text" name="name" value="{{ old('$user->name', $user->name) }}"
                                        class="w-full border rounded px-2 py-1" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Username</label>
                                    <input type="text" name="username" value="{{ old('$user->username', $user->username) }}"
                                        class="w-full border rounded px-2 py-1" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Email</label>
                                    <input type="email" name="email" value="{{ old('$user->email', $user->email) }}"
                                        class="w-full border rounded px-2 py-1">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Role</label>
                                    <select name="role" class="w-full border rounded px-2 py-1" required>
                                        @if (auth()->user()->isSuperAdmin())
                                        <option value="admin"  {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        @endif
                                        <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                                        <option value="user"   {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium">Password (leave blank if not replaced)</label>
                                    <input type="password" name="password" class="w-full border rounded px-2 py-1">
                                </div>

                                <div class="flex gap-2 pt-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                        Save
                                    </button>
                                    <button type="button" @click="edit=false" class="bg-gray-300 px-4 py-2 rounded">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-5 py-6 text-gray-500">No users yet.</li>
            @endforelse
        </ul>
    </div>
</x-layoutadmin>
