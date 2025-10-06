<x-layoutadmin>
  <x-slot:title>Admin - All Posts</x-slot:title>

  <x-alert-success />
  <x-alert-error />

  <!-- Header: Create + Search -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

      <!-- Kiri: Create Post -->
      <a href="{{ route('admin.posts.create') }}"
        class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium shadow transition">
          + Create New Post
      </a>

      <!-- Kanan: Search Form -->
      <form method="GET" action="{{ route('admin.posts.index') }}" 
            class="flex flex-wrap items-center gap-2">

          <!-- Search + Button in one -->
          <div class="relative w-full md:w-56">
              <input type="search" name="search" value="{{ request('search') }}" 
                  placeholder="Search articles..."
                  class="pl-3 pr-10 py-2 rounded border border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm w-full focus:ring-2 focus:ring-blue-500">
              <button type="submit"
                  class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600">
                  <!-- Search Icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                  </svg>
              </button>
          </div>

          <!-- Reset -->
          @if(request('search'))
              <a href="{{ route('admin.posts.index') }}" 
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300 transition">
                  Reset
              </a>
          @endif
      </form>
  </div>

  <!-- Tabel Posts -->
  <div class="max-w-4xl mx-auto mt-5">
    <table class="table-auto w-full border">
      <thead>
          <span class="text-xs text-grey-100">green=published, yellow=draft</span>
          <tr class="bg-gray-100">
              <th class="px-4 py-2 border">Title</th>
              <th class="px-4 py-2 border">Author</th>
              <th class="px-4 py-2 border">Category</th>
              <th class="px-4 py-2 border">Actions</th>
          </tr>
      </thead>
      <tbody>
        @forelse($posts as $post)
        <tr>
          <td class="border px-4 py-2 {{ $post->status === 'published' ? 'text-green-500' : 'text-yellow-500' }}">
            {{ $post->title }}
          </td>
          <td class="border px-4 py-2">{{ $post->author->name ?? '-' }}</td>
          <td class="border px-4 py-2">{{ $post->category->name ?? '-' }}</td>
          <td class="border px-4 py-2">
            <div class="text-justify md:flex space-x-2">
              <a href="{{ route('admin.posts.show', $post->id) }}" class="text-blue-500 ml-2 hover:underline hover:text-green-500">Show</a>
              <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-yellow-500 ml-2 hover:underline hover:text-green-500">Edit</a>
              <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-500 mr-2 hover:underline hover:text-green-500" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="px-6 py-6 text-center text-gray-500">Nothing.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
  </div>
</x-layoutadmin>
