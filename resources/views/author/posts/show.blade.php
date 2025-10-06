<x-layout>
    <x-slot:title>{{ $title ?? 'Post Detail' }}</x-slot:title>

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 mt-10">
        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-6 tracking-tight">
            {{ $post->title }}
        </h1>

        <!-- Meta Info -->
        <div class="flex items-center justify-between mb-6 text-sm text-gray-600">
            <p>Category: <span class="font-semibold text-gray-800">{{ $post->category->name }}</span></p>
            <p>Last Update: <span class="font-semibold text-gray-800">{{ $post->updated_at->format('d M Y, H:i') }}</span></p>
        </div>

        <!-- status -->
        <div class="mb-6">
            <p class="text-sm text-gray-600">Status:
                <span class="px-4 py-2 rounded-md font-semibold
                    @if($post->status === 'published')
                        bg-green-100 text-green-800
                    @elseif($post->status === 'draft')
                        bg-yellow-100 text-yellow-800
                    @else
                        bg-gray-300 text-gray-800
                    @endif">
                    {{ ucfirst($post->status) }}
                </span>
            </p>
        </div>

        <!-- Thumbnail -->
        <img src="{{ $post->photo_url }}" 
             alt="{{ $post->title }}" 
             class="w-full rounded-xl shadow-md mb-6 object-cover"
        >

        <!-- Content -->
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->body)) !!}
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('author.posts.edit', $post->slug) }}" 
               class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
                Edit Post
            </a>

            <form action="{{ route('author.posts.destroy', $post->slug) }}" method="POST"
                  x-data="{ confirmDelete: false }" 
                  @submit.prevent="if(confirmDelete) $el.submit()">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        @click="confirmDelete = confirm('Are you sure you want to delete this post?')"
                        class="px-5 py-2.5 rounded-lg bg-red-600 text-white font-medium shadow hover:bg-red-700 transition">
                    Delete Post
                </button>
            </form>
        </div>
    </div>
</x-layout>
