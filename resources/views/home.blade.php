<x-layout>
  <x-slot:title>{{$title}}</x-slot:title>

  <x-alert-success />
  <x-alert-error />

  <div x-data="{ activeTab: 'dashboard' }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
      <!-- Navigation Tabs -->
      <div class="flex space-x-4 mb-6">
        <button @click="activeTab = 'dashboard'" :class="{ 'bg-indigo-600 text-white': activeTab === 'dashboard', 'bg-white text-gray-700': activeTab !== 'dashboard' }" class="px-4 py-2 rounded-lg transition duration-200">
          Dashboard
        </button>
        <button @click="activeTab = 'team'" :class="{ 'bg-indigo-600 text-white': activeTab === 'team', 'bg-white text-gray-700': activeTab !== 'team' }" class="px-4 py-2 rounded-lg transition duration-200">
          Author
        </button>
      </div>

      <!-- Dashboard Content -->
      <div x-show="activeTab === 'dashboard'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
          <h2 class="text-2xl font-bold text-gray-800 mb-4">Analytics Overview</h2>
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <span class="text-gray-600">Total Users</span>
              <span class="text-green-500 font-semibold">{{ $user_count }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600">Total Authors</span>
              <span class="text-green-500 font-semibold">{{ $author_count }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-gray-600">Total Articles</span>
              <span class="text-green-500 font-semibold">{{ $post_count }}</span>
            </div>
            <!-- <div class="flex items-center justify-between">
              <span class="text-gray-600">Total Categories</span>
              <span class="text-blue-500 font-semibold">{{ $category_count }}</span>
            </div> -->
          </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
          <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Activities</h2>
          <ul class="space-y-3">
            <div class="max-h-20 overflow-y-auto">
              <ul class="space-y-3">
                @foreach($posts as $post)
                <li class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-700">
                          @auth
                            <a href="/posts/{{ $post->slug }}" class="font-semibold hover:underline">
                                {{ Str::limit($post['title'], 30) }}
                            </a>
                          @else
                            <a href="/posts/{{ $post->slug }}" class="font-semibold hover:underline" title="login to view this article">
                                {{ Str::limit($post['title'], 30) }}
                            </a>
                          @endauth
                            by <span class="font-medium">{{ $post->author->name }}</span>
                        </p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </li>
                @endforeach
              </ul>
            </div>
          </ul>
        </div>
        @auth
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
          <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Quick Actions</h2>
            <ul class="space-y-3">
              <div class="text-center mt-6">
                <!-- <a href="/admin/posts" class="text-gray-600 px-4 py-2 rounded hover:bg-blue-500 hover:text-white transition duration-200">
                    Go to Admin Panel
                </a> -->
                <a href="{{ route('admin.posts.index') }}" class="text-white px-4 py-2 rounded hover:shadow-lg hover:text-gray-600 transition duration-200">
                    Go to Admin Panel
                </a>
              </div>
            </ul>
          </div>
          @endif
          @if(Auth::user()->role === 'author')
          <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Create Article</h2>
            <ul class="space-y-3">
              <div class="flex justify-center">
                <a href="{{ route('author.posts.index') }}" 
                  class="inline-block font-semibold px-5 py-2 rounded 
                          bg-green-500
                          text-gray-600 shadow-md transform transition 
                          duration-300 hover:scale-110 hover:bg-green-600">
                    + New Article
                </a>
            </div>
            </ul>
          </div>
          @endif
          @if(Auth::user()->role === 'user')
          <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Explore Articles</h2>
            <ul class="space-y-3">
              <div class="flex justify-center">
                <a href="/posts" 
                  class="inline-block font-semibold px-5 py-2 rounded 
                          bg-indigo-500
                          text-white shadow-md transform transition 
                          duration-300 hover:scale-110 hover:bg-indigo-600">
                    Browse Articles
                </a>
            </div>
            </ul>
          </div>
          @endif
        @endauth
      </div>

      <!-- Team Content -->
      <div x-show="activeTab === 'team'" class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Authors</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($authors as $author)
          <a href="/posts?author={{$author->username}}" class="flex-shrink-0">
          <div class="flex items-center space-x-4 p-4 border rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200">
            <div>
              <h3 class="font-semibold text-gray-800">{{$author->name}}</h3>
              <p class="text-sm text-gray-600">{{$author->email}}</p>
            </div>
          </div>
          </a>
        @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</x-layout>