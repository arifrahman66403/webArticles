<x-layoutadmin>
    <x-layoutsetting />

    {{-- Alerts --}}
    <x-alert-success />
    <x-alert-error />

    {{-- === APP / CRUD OPTIONS === --}}
    <form method="POST" action="{{ route('admin.setting.app.update') }}" 
        class="rounded-xl border p-5 bg-white dark:bg-gray-800 max-w-xl shadow-md">
        @csrf
        <h3 class="mb-4 text-lg font-semibold">CRUD Options</h3>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Posts Per Page</label>
                <input name="posts_per_page" type="number" min="1" 
                    value="{{ old('posts_per_page', $setting->posts_per_page) }}"
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Default Order By</label>
                <select name="default_order_by" 
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                    <option value="created_at" {{ $setting->default_order_by === 'created_at' ? 'selected' : '' }}>Created At</option>
                    <option value="updated_at" {{ $setting->default_order_by === 'updated_at' ? 'selected' : '' }}>Updated At</option>
                    <option value="title" {{ $setting->default_order_by === 'title' ? 'selected' : '' }}>Title</option>
                    <option value="author" {{ $setting->default_order_by === 'author' ? 'selected' : '' }}>Author</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Default Order Direction</label>
                <select name="default_order_dir" 
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600" required>
                    <option value="asc" {{ $setting->default_order_dir === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $setting->default_order_dir === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Filter by Author</label>
                <select name="filter_author_id" 
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
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
                <select name="filter_category_id" 
                    class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    <option value="" {{ is_null($setting->filter_category_id) ? 'selected' : '' }}>-- No Filter --</option>
                    @foreach($all_categories as $cat)
                        <option value="{{ $cat->id }}" {{ $setting->filter_category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-2">
                <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                    Save Options
                </button>
            </div>
        </div>
    </form>
</x-layoutadmin>
