<x-layoutadmin>
  <x-slot:title>Edit Post</x-slot:title>

  <x-alert-success />
  <x-alert-error />

  <div class="max-w-xl mx-auto">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="bg-white p-6 rounded shadow">

        {{-- Title --}}
        <div class="mb-4">
          <label for="title" class="block font-medium">Title</label>
          <input type="text" name="title" id="title" class="w-full border p-2" value="{{ old('title', $post->title) }}" required>
        </div>

        {{-- Slug --}}
        <div class="mb-4">
          <label for="slug" class="block font-medium">Slug</label>
          <input type="text" name="slug" id="slug" class="w-full border p-2" value="{{ old('slug', $post->slug) }}" required>
        </div>

        {{-- Body --}}
        <div class="mb-4">
          <label for="body" class="block font-medium">Body</label>
          <textarea name="body" id="body" class="w-full border p-2" rows="5" required>{{ old('body', $post->body) }}</textarea>
        </div>

        {{-- Photo (Upload) --}}
        <div class="mb-4">
          <label class="block font-medium">Upload New Photo</label>
          
          {{-- Tombol custom --}}
          <button type="button" onclick="document.getElementById('photoEditInput').click()"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
              Change Image
          </button>

          {{-- Input file hidden --}}
          <input type="file" name="photo" id="photoEditInput" accept="image/*" class="hidden"
                onchange="previewImage(event, 'photoEditPreview')">
        </div>

        {{-- Photo Preview --}}
        <div class="mb-4">
          <label class="block font-medium">Photo Preview</label>
          <img id="photoEditPreview" 
              src="{{ $post->photo_url }}" 
              class="w-auto h-48 object-cover rounded {{ $post->photo_url ? '' : 'hidden' }}">
        </div>

        {{-- Category --}}
        <div class="mb-4">
          <label for="category_id" class="block font-medium">Category</label>
          <select name="category_id" id="category_id" class="w-full border p-2" required>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Author --}}
        <div class="mb-4">
          <label for="author_id" class="block font-medium">Author</label>
          <select name="author_id" id="author_id" class="w-full border p-2" required>
            @foreach ($authors as $author)
              <option value="{{ $author->id }}" {{ $author->id == $post->author_id ? 'selected' : '' }}>
                {{ $author->name }}
              </option>
            @endforeach
          </select>
        </div>
        
        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
      </div>
    </form>
  </div>

  {{-- Script Preview --}}
  <x-script-preview />
</x-layoutadmin>
