<x-layout>
  <x-slot:title>
    {{ $title }}
  </x-slot:title>

  {{-- Dynamic Heading Berdasarkan Filter --}}
  <div class="py-4 px-4 mx-auto max-w-screen-xl lg:px-6">
    <!-- <div class="text-center mb-6">
      <h1 class="text-1xl font-bold text-gray-800 dark:text-white">
        @if(request('category'))
          Category: {{ $posts->first()?->category->name ?? 'Unknown' }}
        @elseif(request('author'))
          Author: {{ $posts->first()?->author->name ?? 'Unknown' }}
        @elseif(request('search'))
          Search Results for: "{{ request('search') }}"
        @else
          All Posts
        @endif
      </h1>
    </div> -->

    <div class="mx-auto max-w-screen-md sm:text-center">
      <form>
        @if (request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if (request('author'))
          <input type="hidden" name="author" value="{{ request('author') }}">
        @endif
        <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
          <div class="relative w-full">
            <label for="search" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
            </div>
            <input class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="Search for article" type="search" id="search" name="search" autocomplete="on">
          </div>
          <div>
            <button type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-indigo-700 border-indigo-600 sm:rounded-none sm:rounded-r-lg hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- Cards --}}
  <div class="py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-0">
    <!-- <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($posts as $post)
        <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden transition duration-300 hover:shadow-xl hover:-translate-y-1">

          <a href="/posts/{{ $post->slug }}">
            <img 
              class="w-full h-56 object-cover hover:scale-105 transition-transform duration-500"
              src="{{ $post->photo }}"
              alt="{{ $post->title }}" 
            />
          </a>

          <div class="p-6 flex flex-col justify-between h-full">

            <div class="flex justify-between items-center mb-4">
              <a href="/posts?category={{ $post->category->slug }}">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-{{ $post->category->color }}-100 text-white shadow-sm">
                  {{ $post->category->name }}
                </span>
              </a>
              <span class="text-xs text-gray-400">{{ $post->updated_at->diffForHumans() }}</span>
            </div>

            <a href="/posts/{{ $post->slug }}">
              <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-indigo-600 transition">
                {{ $post->title }}
              </h2>
            </a>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
              {{ Str::limit($post->body, 120) }}
            </p>

            <div class="flex justify-between items-center mt-auto">
              <a href="/posts?author={{ $post->author->username }}" class="flex items-center gap-2 hover:opacity-80 transition">
                <img 
                  class="w-8 h-8 rounded-full object-cover"
                  src="{{ $post->author->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode($post->author->id) }}"
                  alt="{{ $post->author->name }}" 
                />
                <div class="flex flex-col leading-tight">
                  <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $post->author->name }}</span>
                  <span class="text-xs text-gray-500">{{ ucfirst($post->author->role) }}</span>
                </div>
              </a>

              <a href="/posts/{{ $post->slug }}" class="px-3 py-1 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition">
                Read more →
              </a>
            </div>
          </div>
        </article>
      @empty
        <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
          <div class="text-center">
            <p class="text-base font-semibold text-indigo-600">404</p>
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Page not found</h1>
            <p class="mt-6 text-lg text-gray-500">Sorry, we couldn’t find the page you’re looking for.</p>
            <div class="mt-10 flex justify-center">
              <a href="/posts" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                Go back Posts
              </a>
            </div>
          </div>
        </main>
      @endforelse
    </div> -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      @forelse ($posts as $post)
      <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 transition-transform duration-300 hover:scale-105">
        <img class="w-62 h-38 md:w-96 md:h-60 lg:w-96 lg:h-64 rounded-lg mb-5 object-cover hover:scale-105 transition-transform duration-500" src="{{ $post->photo_url }}" alt="{{ $post->photo_url }}" />
        <div class="flex justify-between items-center mb-5 text-gray-500">
          <a href="/posts?category={{ $post->category->slug }}" class="hover:text-green-600">
            <span class="bg-{{ $post->category->color }}-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800 transition-transform duration-300 hover:scale-105 hover:text-green-500">
              {{ $post->category->name }}
            </span>
          </a>
          <div 
            x-data="{ 
              sort: '{{ request('sort', 'created_at') }}', 
              hover: false 
            }" 
            class="inline-block text-sm hover:upperline cursor-pointer"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            @click.prevent="sort = (sort === 'created_at' ? 'updated_at' : 'created_at')"
          >
              <!-- Default (tidak hover) -->
              <span x-show="!hover" x-cloak>
                  <span x-text="sort === 'updated_at' ? '{{ $post->updated_at->diffForHumans() }}' : '{{ $post->created_at->diffForHumans() }}'"></span>
              </span>

              <!-- Saat hover -->
              <span x-show="hover" x-cloak>
                  <template x-if="sort === 'updated_at'">
                      <span>Updated at {{ $post->updated_at->diffForHumans() }}</span>
                  </template>
                  <template x-if="sort === 'created_at'">
                      <span>Created at {{ $post->created_at->diffForHumans() }}</span>
                  </template>
              </span>
          </div>
        </div>
        <a href="/posts/{{ $post->slug }}" class="hover:underline">
          @auth
          <h2 class="mb-2 text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:-translate-y-1 transition duration-200">{{ $post->title }}</h2>
          @else
          <h2 class="mb-2 text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:-translate-y-1 transition duration-200" title="login to view this article">{{ $post->title }}</h2>
          @endauth
        </a>
        <p class="mb-5 font-light sm:text-md lg:text-md text-gray-500 dark:text-gray-400">{{ Str::limit($post['body'], 150) }}</p>
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-2">
            <a href="/about/{{ $post->author->username }}" class="hover:ring-2 hover:focus:ring-offset-2 hover:focus:ring-indigo-500 rounded-full">
            <img class="w-7 h-7 object-cover rounded-full" src="{{ $post->author->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode($post->author->id) }}" alt="{{ $post->author->name }}" />
            </a>
            <a href="/posts?author={{ $post->author->username }}" class="font-medium text-sm dark:text-white hover:underline hover:text-gray-600 transition">
              {{ $post->author->name }}
            </a>
          </div>
          <a href="/posts/{{ $post->slug }}" class="px-3 py-1 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-500">
            Read more
          </a>
        </div>
      </article>
      @empty
      <div class="col-span-full">
        <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
          <p class="text-base font-semibold text-indigo-600">404</p>
          <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">Page not found</h1>
          <p class="mt-6 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">Sorry, we couldn’t find the page you’re looking for.</p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="/posts" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back Posts</a>
          </div>
        </div>
      </main>
      </div>
      @endforelse
      </div>
    </div>
    <div class="mt-4">
      {{ $posts->withQueryString()->links() }}
    </div>
  </div>
</x-layout>