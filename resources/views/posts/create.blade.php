<x-layoutadmin>
  <x-slot:title>Create New Post</x-slot:title>

  <x-alert-success />
  <x-alert-error />

  <div class="max-w-xl mx-auto">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="bg-white p-6 rounded shadow">

        {{-- Title --}}
        <div class="mb-4">
          <label for="title" class="block font-medium">Title</label>
          <input type="text" name="title" id="title" class="w-full border p-2" required>
        </div>

        {{-- Slug --}}
        <div class="mb-4">
          <label for="slug" class="block font-medium">Slug</label>
          <input type="text" name="slug" id="slug" class="w-full border p-2" required>
        </div>

        {{-- Body --}}
        <div class="mb-4">
          <label for="body" class="block font-medium">Body</label>
          <textarea name="body" id="body" class="w-full border p-2" rows="5" required></textarea>
        </div>

        {{-- Photo (Upload) --}}
        <div class="mb-4">
          <label class="block font-medium">Upload Photo</label>

          {{-- Tombol custom --}}
          <button type="button" onclick="document.getElementById('photoCreateInput').click()"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
              Upload Image
          </button>

          {{-- Input file hidden --}}
          <input type="file" name="photo" id="photoCreateInput" accept="image/*" class="hidden"
                onchange="previewImage(event, 'photoCreatePreview')">
        </div>

        {{-- Photo Preview --}}
        <div class="mb-4">
          <label class="block font-medium">Photo Preview</label>
          <img id="photoCreatePreview" class="w-auto h-48 object-cover rounded hidden">
        </div>

        {{-- Category --}}
        <div class="mb-4">
          <label for="category_id" class="block font-medium">Category</label>
          <select name="category_id" id="category_id" class="w-full border p-2" required>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Author --}}
        <div class="mb-4">
          <label for="author_id" class="block font-medium">Author</label>
          <select name="author_id" id="author_id" class="w-full border p-2" required>
            @foreach ($authors as $author)
              <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Create Post</button>
      </div>
    </form>
  </div>

  {{-- Script Preview --}}
  <x-script-preview />
</x-layoutadmin>
