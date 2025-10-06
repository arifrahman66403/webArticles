<x-layout>
    <x-slot:title>{{ $title ?? 'Edit Post' }}</x-slot:title>

    <x-alert-error />

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-6 mt-6">
        <form action="{{ route('author.posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label for="slug" class="block font-medium text-gray-700">Slug (auto)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}"
                    class="w-full border rounded-lg px-4 py-2 mt-1 text-gray-500 focus:ring focus:ring-blue-200 focus:outline-none" readonly>
            </div>

            <div>
                <label for="category_id" class="block font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring focus:ring-blue-200 focus:outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="photo" class="block font-medium text-gray-700">Image</label>

                <!-- Tombol custom -->
                <button type="button" onclick="document.getElementById('photoEditInput').click()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Change Image
                </button>

                <!-- Input file hidden -->
                <input type="file" name="photo" id="photoEditInput" accept="image/*" class="hidden"
                    onchange="previewImage(event, 'previewEdit')">

                <!-- Preview -->
                <img id="previewEdit" 
                    src="{{ $post->photo_url }}"
                    class="mt-3 w-full h-auto object-cover rounded-lg shadow"
                    alt="Image Preview"
                >
            </div>

            <div>
                <label for="body" class="block font-medium text-gray-700">Content</label>
                <textarea name="body" id="body" rows="6"
                    class="w-full border rounded-lg px-4 py-2 mt-1 focus:ring focus:ring-blue-200 focus:outline-none">{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('author.posts.index') }}" 
                   class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                    Cancel
                </a>

                <!-- Tombol Draft -->
                <button type="submit" name="status" value="draft"
                    class="px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition">
                    Save as Draft
                </button>

                <!-- Tombol Publish -->
                <button type="submit" name="status" value="published"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                    Publish
                </button>
            </div>
        </form>
    </div>
    <x-script-preview />
</x-layout>
