<x-layout>
    <x-slot:title>My Library</x-slot:title>

    <x-alert-success/>
    <x-alert-error/>

    <div class="max-w-4xl mx-auto mt-8">

        @if($likedPosts->isEmpty())
            <div class="p-32 text-center text-gray-500">
                <p class="">You haven't liked any posts yet.</p>
                <a href="{{ route('posts.index') }}" class="hover:text-blue-700">
                    Browse Posts
                </a>
            </div>
        @else
            <div class="grid gap-6 grid-cols-2 md:grid-cols-3">
                @foreach($likedPosts as $post)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-3 flex flex-col">
                        {{-- Cover Image (opsional kalau ada) --}}
                        @if($post->photo_url)
                            <img src="{{ $post->photo_url }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-24 object-cover rounded-lg md:w-full md:h-40 mb-2">
                        @endif

                        {{-- Title --}}
                        <h2 class="text-sm md:text-lg font-bold text-gray-800 mb-1">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h2>

                        {{-- Meta info --}}
                        <p class="text-xs md:text-sm text-gray-500 mb-2">
                            By <span class="font-medium">{{ $post->author->name }}</span> • 
                            {{ $post->created_at->diffForHumans() }}
                        </p>

                        {{-- Excerpt --}}
                        <p class="text-gray-700 mb-3 flex-grow text-xs md:text-sm">
                            {{ Str::limit($post->body, 80) }}
                        </p>

                        {{-- Footer: Like count & Read More --}}
                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center space-x-1">
                                @auth
                                    <livewire:like-button :post="$post" :wire:key="'like-button-2'.$post->id" />
                                @else
                                    <span class="text-gray-400">🤍</span>
                                @endauth
                            </div>

                            <a href="{{ route('posts.show', $post) }}" 
                            class="px-2 py-1 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Read More
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
