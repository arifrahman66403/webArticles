<x-layout>
    <x-slot:title>Create New Article</x-slot:title>

    <x-alert-error />

    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-6 mt-6">
        <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/\s+/g, '-')"
                    required>
                @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Slug (auto)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-gray-500" readonly>
                @error('slug') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected':'' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Photo</label>

                <!-- Tombol custom -->
                <button type="button" onclick="document.getElementById('photoCreateInput').click()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Upload Image
                </button>

                <!-- Input file hidden -->
                <input type="file" name="photo" id="photoCreateInput" accept="image/*" class="hidden"
                    onchange="previewImage(event, 'previewCreate')">
                @error('photo') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                <!-- Preview -->
                <img id="previewCreate" class="mt-3 w-full h-auto object-cover rounded-lg shadow hidden">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="body" rows="6"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('body') }}</textarea>
                @error('body') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('author.posts.index') }}" 
                class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100 transition">
                    Cancel
                </a>

                <button type="submit" name="status" value="draft"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                    Save as Draft
                </button>

                <button type="submit" name="status" value="published"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    Publish
                </button>
            </div>
        </form>
    </div>
    <x-script-preview />
</x-layout>
