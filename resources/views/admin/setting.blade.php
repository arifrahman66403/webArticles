<x-layoutadmin>
    <x-layoutsetting>

    <div class="p-6" x-data="{ tab: 'profile' }">
        <!-- Success Alert -->
        <x-alert-success />

        <!-- Error Alert -->
        <x-alertsetting-error />

        {{-- Tabs --}}
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex gap-4">
                <button @click="tab='profile'" :class="tab==='profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium">Profile</button>

                <button @click="tab='users'" :class="tab==='users' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium">Users</button>

                <button @click="tab='categories'" :class="tab==='categories' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium">Categories</button>

                <button @click="tab='app'" :class="tab==='app' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium">CRUD Options</button>
            </nav>
        </div>

        {{-- === PROFILE === --}}
        <section x-show="tab==='profile'" x-transition>
            <div class="grid gap-6 md:grid-cols-2">
                {{-- Update profile --}}
                <form method="POST" action="{{ route('admin.setting.profile') }}" class="rounded-xl border p-5 bg-white dark:bg-gray-800">
                    @csrf
                    <h3 class="mb-4 text-lg font-semibold">Profile</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Name</label>
                            <input name="name" type="text" value="{{ old('Auth::user()->name', Auth::user()->name) }}" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Username</label>
                            <input name="username" type="text" value="{{ old('Auth::user()->username', Auth::user()->username) }}" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input name="email" type="email" value="{{ old('Auth::user()->email', Auth::user()->email) }}" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div class="pt-2">
                            <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save</button>
                        </div>
                    </div>
                </form>

                {{-- Update password --}}
                <form method="POST" action="{{ route('admin.setting.password') }}" class="rounded-xl border p-5 bg-white dark:bg-gray-800">
                    @csrf
                    <h3 class="mb-4 text-lg font-semibold">Change Password</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Current Password</label>
                            <input name="current_password" type="password" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">New Password</label>
                            <input name="password" type="password" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                            <input name="password_confirmation" type="password" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                        </div>
                        <div class="pt-2">
                            <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        {{-- === USER === --}}
        <section x-show="tab==='users'" x-transition class="space-y-6">
            {{-- Form tambah user (collapsible) --}}
            <div x-data="{ open: false }" class="rounded-xl border bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center p-4 dark:border-gray-700">
                    <h3 class="text-lg font-semibold">Add User</h3>
                    <button type="button"
                        @click="open = !open"
                        class="mr-2 text-xl transition-transform duration-300 hover:scale-110">
                        <span x-text="open ? '✕' : '☰'"></span>
                        <!-- class="px-3 py-1 text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                        <span x-text="open ? '&minus; Close' : '&plus; Open'"></span> -->
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
                            <option value="admin">Admin</option>
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
                        <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Add user</button>
                    </div>
                </form>
            </div>

            {{-- List User --}}
            <div class="rounded-xl border bg-white dark:bg-gray-800">
                <!-- <div class="px-5 py-3 border-b dark:border-gray-700 font-semibold">All Users</div> -->
                <div class="px-5 py-3 border-b dark:border-gray-700 font-semibold flex justify-between items-center">
                    <span>All Users <span class="text-sm text-gray-500">({{ $users->count() }} users)</span></span>
                    <form>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search users..."
                            class="px-2 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
                    </form>
                </div>
                <ul class="divide-y dark:divide-gray-700">
                    @forelse($users as $user)
                        <li class="px-5 py-3 flex justify-between items-center"
                            x-data="{ edit:false }">

                            <span>{{ $user->name }} ({{ $user->username }}) - {{ $user->role }}</span>

                            {{-- Tombol aksi --}}
                            <div class="flex gap-2">
                                <button @click="edit=true" class="px-3 py-1 rounded-md border">Edit</button>
                                <form method="POST" action="{{ route('admin.setting.users.destroy', $user) }}" onsubmit="return confirm('Are you sure to delete {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 rounded-md bg-red-600 text-white">Delete</button>
                                </form>
                            </div>

                            {{-- Pop-up edit --}}
                            <div x-show="edit"
                                style="background-color: rgba(0,0,0,0.5)"
                                class="fixed inset-0 flex items-center justify-center z-50">

                                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg shadow-lg mx-4">
                                    <h2 class="text-lg font-semibold mb-4">Edit User</h2>
                                    <!-- Form Edit user -->
                                    <form method="POST" action="{{ route('admin.setting.users.update', $user->username) }}" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-sm font-medium">Name</label>
                                            <input type="text" name="name" value="{{ old($user->name, $user->name) }}"
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
                                                <option value="admin"  {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="author"  {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                                                <option value="user"   {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Password (leave blank if not replaced)</label>
                                            <input type="password" name="password" class="w-full border rounded px-2 py-1">
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
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
        </section>

        {{-- === CATEGORIES === --}}
        <section x-show="tab==='categories'" x-transition class="space-y-6">
            {{-- Create --}}
            <form method="POST" action="{{ route('admin.setting.categories.store') }}" class="rounded-xl border p-5 bg-white dark:bg-gray-800">
                @csrf
                <h3 class="mb-4 text-lg font-semibold">Add Category</h3>
                <div class="flex gap-3">
                    <input name="name" type="text" placeholder="Category name" class="flex-1 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                    <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Add</button>
                </div>
            </form>

            {{-- List + popup edit --}}
            <div class="rounded-xl border bg-white dark:bg-gray-800">
                <div class="px-5 py-3 border-b dark:border-gray-700 font-semibold">All Categories</div>
                <ul class="divide-y dark:divide-gray-700">
                    @forelse($categories as $c)
                        <li class="px-5 py-3" x-data="{ openEdit:false }">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    {{-- tampilkan warna --}}
                                    <span class="w-4 h-4 rounded-full" style="background-color: {{ $c->color ?? '#ccc' }}"></span>
                                    <span class="font-medium">{{ $c->name }}</span>
                                    <span class="text-gray-500 text-sm">({{ $c->slug }})</span>
                                </div>

                                <div class="flex gap-2">
                                    <button @click="openEdit=true" 
                                        class="px-3 py-1 rounded-md border">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.setting.categories.destroy', $c) }}" 
                                        onsubmit="return confirm('Delete this category?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1 rounded-md bg-red-600 text-white">Delete</button>
                                    </form>
                                </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div x-show="openEdit" x-cloak
                                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                                <div @click.away="openEdit=false" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6">
                                    <h2 class="text-lg font-semibold mb-4">Edit Category</h2>

                                    <form method="POST" action="{{ route('admin.setting.categories.update', $c) }}" class="space-y-4">
                                        @csrf @method('PUT')

                                        <div>
                                            <label class="block text-sm mb-1">Name</label>
                                            <input type="text" name="name" value="{{ $c->name }}"
                                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1">Color (hex/text)</label>
                                            <input type="text" name="color" value="{{ $c->color ?? '#cccccc' }}"
                                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                                placeholder="example: #ff0000 or red">
                                        </div>

                                        <div>
                                            <label class="block text-sm mb-1">Slug (auto)</label>
                                            <input type="text" name="slug" value="{{ $c->slug }}" readonly
                                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-gray-500">
                                        </div>

                                        <div class="flex justify-end gap-2 pt-4">
                                            <button type="button" @click="openEdit=false"
                                                class="px-4 py-2 rounded-md border">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 rounded-md bg-green-600 text-white">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-6 text-gray-500">No categories yet.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        {{-- === APP / CRUD OPTIONS === --}}
        <section x-show="tab==='app'" x-transition>
            <form method="POST" action="{{ route('admin.setting.app') }}" class="rounded-xl border p-5 bg-white dark:bg-gray-800 max-w-xl">
                @csrf
                <h3 class="mb-4 text-lg font-semibold">CRUD Options</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Posts Per Page</label>
                        <input name="posts_per_page" type="number" min="1" value="{{ old('posts_per_page', $setting->posts_per_page) }}"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Default Order By</label>
                        <select name="default_order_by" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                            <option value="created_at" {{ $setting->default_order_by === 'created_at' ? 'selected' : '' }}>Created At</option>
                            <option value="title" {{ $setting->default_order_by === 'title' ? 'selected' : '' }}>Title</option>
                            <option value="author" {{ $setting->default_order_by === 'author' ? 'selected' : '' }}>Author</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Default Order Direction</label>
                        <select name="default_order_dir" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                            <option value="asc" {{ $setting->default_order_dir === 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ $setting->default_order_dir === 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Filter by Author</label>
                        <select name="filter_author_id" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                            <option value="" {{ is_null($setting->filter_author_id) ? 'selected' : '' }}>-- No Filter --</option>
                            @foreach($all_authors as $author)
                                <option value="{{ $author->id }}" {{ $setting->filter_author_id == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }} ({{ $author->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Filter by Category</label>
                        <select name="filter_category_id" class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                            <option value="" {{ is_null($setting->filter_category_id) ? 'selected' : '' }}>-- No Filter --</option>
                            @foreach($all_categories as $cat)
                                <option value="{{ $cat->id }}" {{ $setting->filter_category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-2">
                        <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save Options</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
    </x-layoutsetting>
</x-layoutadmin>
