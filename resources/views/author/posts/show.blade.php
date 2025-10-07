<x-layout>
    <x-slot:title>{{ $title ?? 'Post Detail' }}</x-slot:title>

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8 mt-10">
        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 mb-6 tracking-tight">
            {{ $post->title }}
        </h1>

        <!-- Meta Info -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6 text-sm text-gray-600 border-b pb-3">
            <p>Category: 
                <span class="font-semibold text-gray-800">{{ $post->category->name }}</span>
            </p>
            <p>Last Update: 
                <span class="font-semibold text-gray-800">{{ $post->updated_at->format('d M Y, H:i') }}</span>
            </p>
        </div>

        <!-- Status -->
        <div class="mb-6">
            <p class="text-sm text-gray-600">
                Status:
                <span class="px-3 py-1.5 rounded-md font-semibold text-sm
                    @if($post->status === 'published')
                        bg-green-100 text-green-800
                    @elseif($post->status === 'draft')
                        bg-yellow-100 text-yellow-800
                    @else
                        bg-gray-200 text-gray-800
                    @endif">
                    {{ ucfirst($post->status) }}
                </span>
            </p>
        </div>

        <!-- Thumbnail -->
        <img src="{{ $post->photo_url }}" 
             alt="{{ $post->title }}" 
             class="w-full rounded-xl shadow-md mb-6 object-cover">

        <!-- Content -->
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->body)) !!}
        </div>

        <!-- Interaction Section -->
        <div class="flex items-center justify-between border-t mt-8 pt-4 text-gray-600 text-sm">
            <!-- Likes -->
            <div class="flex items-center gap-1">
                <!-- Heart Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="currentColor" 
                     viewBox="0 0 24 24" 
                     class="w-5 h-5 text-red-500">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                             2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 
                             4.5 2.09C13.09 3.81 14.76 3 16.5 3 
                             19.58 3 22 5.42 22 8.5c0 3.78-3.4 
                             6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span>{{ $post->likes()->count() }}</span>
            </div>

            <!-- Comments -->
            <div class="flex items-center gap-1">
                <!-- Comment Icon -->
                <svg class="w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 
                    01-2-2V6a2 2 0 012-2h14a2 2 0 
                    012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <span>{{ $post->comments()->count() }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('author.posts.edit', $post->slug) }}" 
               class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
                Edit Post
            </a>

            <form action="{{ route('author.posts.destroy', $post->slug) }}" 
                  method="POST"
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
