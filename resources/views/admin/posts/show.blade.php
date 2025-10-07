<x-layoutadmin>
  <x-slot:title>{{ $title }}</x-slot:title>

  <!-- <div class="max-w-2xl mx-auto space-y-6"> -->
  <div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:underline">&laquo; Back to All Posts</a>

    <div class="bg-white p-6 rounded shadow">
      <img src="{{ $post->photo_url }}" alt="{{ $post->photo_url }}" class="rounded w-full h-auto mb-4">
      <h1 class="text-2xl font-bold mb-1">{{ $post->title }}</h1>
      <p class="text-gray-600 text-sm mb-4">
        Category: <strong>{{ $post->category->name }}</strong> |
        Author: <strong>{{ $post->author->name }}</strong> |
        Published: <strong>{{ $post->created_at->diffForHumans() }}</strong> |
        Last Updated: <strong>{{ $post->updated_at->diffForHumans() }}</strong> |
        Status: <strong class="{{ $post->status === 'published' ? 'text-green-500' : 'text-yellow-500' }}">{{ ucfirst($post->status) }}</strong>
      </p>
      <div class="text-gray-800 leading-relaxed">
        {!! nl2br(e($post->body)) !!}
      </div>
    </div>
  </div>
</x-layoutadmin>
