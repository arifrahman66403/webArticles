<x-layout>
  <x-slot:title>
    <a href="/posts?category={{ $post->category->slug }}" class="hover:underline">
        {{ $post->category->name }}
    </a> | {{ $post->title }}
  </x-slot:title>

  <x-alert />
  <x-alert-error />
   
    <div x-data="{ open: false }">
    <!-- Tombol buka drawer -->
    <div class="flex justify-end">
      <button @click="open = true" class="rounded-md bg-indigo-500 hover:bg-indigo-700 text-white font-bold font-size-xs py-0.5 px-1 md:py-2 md:px-4 md:font-size-md transition">
        Show Another
      </button>
    </div>
    <!-- Overlay (Backrop) -->
    <div 
      x-show="open" 
      x-transition.opacity 
      class="fixed inset-0 bg-black bg-opacity-50 z-40"
      @click="open = false"
    ></div>

    <!-- Drawer -->
    <div 
      x-show="open" 
      x-transition:enter="transition ease-out duration-500" 
      x-transition:enter-start="translate-x-full" 
      x-transition:enter-end="translate-x-0" 
      x-transition:leave="transition ease-in duration-400" 
      x-transition:leave-start="translate-x-0" 
      x-transition:leave-end="translate-x-full"
      class="fixed top-0 right-0 w-full max-w-md h-full bg-white shadow-xl z-50 p-6 overflow-y-auto"
    >
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Others Article</h2>
        <button @click="open = false" class="text-gray-500 hover:text-gray-800">&times;</button>
      </div>

      <div class="mt-4 grid grid-cols-2 md:grid-cols-2 gap-4">
        @foreach($other->random(12) as $p)
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
          <div class="h-40 bg-gray-200 rounded-md mb-4 overflow-hidden">
            <img src="{{$p->photo_url}}" alt="{{$p->photo_url}}" class="w-40 h-40 object-cover">
          </div>
          <h3 class="text-md font-semibold mb-2">{{$p->title}}</h3>
          <p class="text-gray-600 text-sm mb-3">{{$p->excerpt}}</p>
          <a href="/posts/{{$p->slug}}" class="text-indigo-500 hover:text-indigo-700 text-sm font-medium">Read more</a>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <main class="pt-2 pb-4 lg:pt-4 lg:pb-8 dark:bg-gray-900 antialiased">
    <div class="flex justify-between px-4 mx-auto max-w-screen-xl">
      <article 
        class="mx-auto w-full max-w-4xl bg-white rounded-lg shadow-md p-6 format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">

        <!-- Header -->
        <header class="mb-4 lg:mb-6 not-format">
          <!-- <div class="flex justify-between items-center">
            <a href="{{ url()->previous() }}" 
              class="px-2 py-1 text-sm md:px-3 md:py-1 md:text-lg font-semibold text-indigo-500 hover:rounded-lg hover:bg-indigo-500 hover:text-white transition">
              Back to all posts
            </a>
          </div> -->

          <address class="flex items-center mb-6 not-italic">
            <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
              <a href="/about/{{ $post->author->username }}" 
                class="hover:ring-2 hover:focus:ring-offset-2 hover:focus:ring-indigo-500 rounded-full mr-4">
                <img class="w-10 h-10 md:w-16 md:h-16 object-cover rounded-full" 
                    src="{{ $post->author->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode($post->author->id) }}" 
                    alt="{{ $post->author->name }}" />
              </a>
              <div>
                <a href="/posts?author={{$post->author->username}}" 
                  class="text-md md:text-xl font-bold text-gray-900 dark:text-white hover:underline">
                  {{$post->author->name}}
                </a>
                <p class="text-sm text-gray-400">
                  {{ $post->created_at->diffForHumans() }}
                </p>
              </div>
            </div>
          </address>

          <img class="w-full h-64 md:h-96 object-cover rounded-md mb-4" 
              src="{{ $post->photo_url }}" 
              alt="{{$post->photo_url}}" />

          <h1 class="my-3 text-xl font-bold leading-tight text-gray-900 md:font-extrabold md:text-3xl">
            {{$post->title}}
          </h1>
        </header>

        <!-- Body -->
        <div class="my-4 text-justify">
          <p class="text-sm md:text-lg">{!! nl2br(e($post->body)) !!}</p>
        </div>

        <!-- Like & Comment Section -->
        <div class="mt-6 border-t pt-4">
          <div class="flex items-center justify-between mb-4">
            
            <!-- Like & Comment Buttons -->
            <div class="flex gap-6 text-gray-600 text-sm">

              <!-- Like -->
              @auth
                <livewire:like-button :post="$post" :wire:key="'like-button-'.$post->id" />
              @endauth

              <!-- Comment Button & Form -->
              <div x-data="{ showCommentForm: false }">
                <button @click="showCommentForm = !showCommentForm" 
                  class="flex items-center gap-1 text-gray-500 hover:text-indigo-600 transition">
                  <!-- Comment Icon -->
                  <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" 
                      fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 
                        01-2-2V6a2 2 0 012-2h14a2 2 0 
                        012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                  </svg>
                  <span>{{ $post->comments_count }}</span>
                </button>

                <!-- Hidden Comment Form -->
                <form x-show="showCommentForm" x-transition 
                      action="{{ route('comments.store', $post) }}" 
                      method="POST" class="mb-6">
                  @csrf
                  <textarea name="body" rows="2"
                    class="w-full border rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Write your comment..."></textarea>
                  <button type="submit"
                    class="mt-2 px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs md:text-sm transition">
                    Post Comment
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Daftar Comment -->
          <div class="space-y-4">
              @forelse($post->comments as $comment)
                  <x-comment :comment="$comment" level="1" />
              @empty
                  <p class="text-gray-500 text-sm">No comments yet. Be the first to comment!</p>
              @endforelse
          </div>
        </div>
      </article>
    </div>
  </main>
</x-layout>
<div 
    x-data="{ show: false, type: '', message: '' }"
    @flash-message.window="
        type = $event.detail.type;
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 5000);
        console.log('Flash Event:', $event.detail); // Debug log
    "
    x-show="show"
    x-transition
    class="fixed top-5 right-5 z-50 w-80 rounded-lg shadow-lg"
    :class="{
        'bg-green-100 border border-green-300 text-green-700': type === 'success',
        'bg-red-100 border border-red-300 text-red-700': type === 'error'
    }"
    style="display: none;"
>
    <div class="p-4 flex items-start gap-3">
        <div class="flex-1">
            <p class="font-semibold" x-text="type === 'success' ? 'Success' : 'Error'"></p>
            <p class="text-sm" x-text="message"></p>
        </div>
        <button @click="show = false" class="text-gray-600 hover:text-gray-800">✕</button>
    </div>
</div>
