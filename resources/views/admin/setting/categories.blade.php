<x-layoutadmin>
    <x-layoutsetting />

    {{-- Alerts --}}
    <x-alert-success />
    <x-alert-error />

    {{-- === CATEGORIES === --}}
    {{-- From tambah category --}}
    <div x-data="{ open: false }" class="rounded-xl border bg-white dark:bg-gray-800 shadow-md mb-6">
        <div class="flex justify-between items-center p-4 dark:border-gray-700">
            <h3 class="text-lg font-semibold">Add Category</h3>
            <button type="button"
                @click="open = !open"
                class="mr-2 text-xl transition-transform duration-300 hover:scale-110">
                <span x-text="open ? '✕' : '☰'"></span>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.setting.categories.store') }}"
            x-show="open"
            x-transition
            class="p-5 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input id="name" name="name" type="text" placeholder="Category name"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                    oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/\s+/g, '-')"
                    required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Color (hex/text)</label>
                <input id="color" name="color" type="text" placeholder="Category color"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                    value="#cccccc">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Slug (auto)</label>
                <input id="slug" name="slug" type="text" placeholder="category-slug"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-gray-500"
                    readonly>
            </div>
            <div class="pt-2">
                <button class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">
                    Add Category
                </button>
            </div>
        </form>
    </div>

    {{-- List + popup edit --}}
    <div class="rounded-xl border bg-white dark:bg-gray-800 shadow-md">
        <div class="px-5 py-3 border-b dark:border-gray-700 font-semibold flex justify-between items-center">
            <span>All Categories <span class="text-sm text-gray-500">({{ $categories->count() }} categories)</span></span>
            <form>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                    class="px-2 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
            </form>
        </div>
        <ul class="divide-y dark:divide-gray-700">
            @forelse($categories as $c)
                <li class="px-5 py-3" x-data="{ openEdit:false }">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
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
                        <div @click.away="openEdit=false" 
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 mx-4">
                            <h2 class="text-lg font-semibold mb-4">Edit Category</h2>

                            <form method="POST" action="{{ route('admin.setting.categories.update', $c) }}" class="space-y-4">
                                @csrf @method('PUT')

                                <div>
                                    <label class="block text-sm mb-1">Name</label>
                                    <input id="name" type="text" name="name" value="{{ $c->name ?? '' }}"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                        oninput="
                                            const slugInput = document.getElementById('slug');
                                            const base = this.value.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
                                            slugInput.value = base;
                                        "
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1">Color (hex/text)</label>
                                    <input type="text" name="color" value="{{ $c->color ?? '#cccccc' }}"
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                        placeholder="example: #ff0000 or red">
                                </div>

                                <div>
                                    <label class="block text-sm mb-1">Slug (auto)</label>
                                    <input id="slug" type="text" name="slug" value="{{ $c->slug ?? '' }}" readonly
                                        class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-gray-500">
                                </div>

                                <div class="flex justify-end gap-2 pt-4">
                                    <button type="button" @click="openEdit=false"
                                        class="px-4 py-2 rounded-md border">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Save</button>
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
</x-layoutadmin>
