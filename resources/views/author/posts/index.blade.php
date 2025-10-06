<x-layout>
    <x-slot:title>My Articles</x-slot:title>

    <x-alert-success />
    <x-alert-error />

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <!-- Left: New Article -->
        <a href="{{ route('author.posts.create') }}"
        class="px-5 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 transition w-full md:w-auto text-center">
        + New Article
        </a>

        <!-- Right: Filter Form -->
        <form method="GET" action="{{ route('author.posts.index') }}" 
            class="flex flex-wrap items-center gap-2 w-full md:w-auto justify-end">

            {{-- Category --}}
            <select name="category" 
                class="px-3 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm w-full md:w-40">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            {{-- Search + Button in one --}}
            <div class="relative w-full md:w-56">
                <input type="search" name="search" value="{{ request('search') }}" 
                    placeholder="Search articles..."
                    class="pl-3 pr-10 py-2 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm w-full focus:ring-2 focus:ring-blue-500">
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

            {{-- Reset --}}
            @if(request('search') || request('category'))
                <a href="{{ route('author.posts.index') }}" 
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    {{-- Title --}}
                    <th class="px-4 py-2 border text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        @php
                            $sort = request('sort');
                            $direction = request('direction');
                            $isTitle = $sort === 'title';
                            $nextDirection = 'asc';

                            if ($isTitle && $direction === 'asc') {
                                $nextDirection = 'desc';
                            } elseif ($isTitle && $direction === 'desc') {
                                $nextDirection = null; // klik ke-3 = reset
                            }
                        @endphp

                        <a href="{{ $nextDirection 
                            ? route('author.posts.index', [
                                'sort' => 'title',
                                'direction' => $nextDirection,
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                            : route('author.posts.index', [
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                        }}" 
                        class="flex items-center space-x-1 hover:text-blue-600">
                            <span>Title</span>
                            @if($isTitle)
                                @if($direction === 'asc')
                                    <span>▲</span>
                                @elseif($direction === 'desc')
                                    <span>▼</span>
                                @endif
                            @endif
                        </a>
                    </th>

                    {{-- Category (no sort) --}}
                    <th class="px-4 py-2 border text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Category
                    </th>

                    {{-- Created --}}
                    <th class="px-4 py-2 border text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        @php
                            $isCreated = $sort === 'created_at';
                            $nextDirection = 'asc';

                            if ($isCreated && $direction === 'asc') {
                                $nextDirection = 'desc';
                            } elseif ($isCreated && $direction === 'desc') {
                                $nextDirection = null; // reset
                            }
                        @endphp

                        <a href="{{ $nextDirection 
                            ? route('author.posts.index', [
                                'sort' => 'created_at',
                                'direction' => $nextDirection,
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                            : route('author.posts.index', [
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                        }}" 
                        class="flex items-center space-x-1 hover:text-blue-600">
                            <span>Created</span>
                            @if($isCreated)
                                @if($direction === 'asc')
                                    <span>▲</span>
                                @elseif($direction === 'desc')
                                    <span>▼</span>
                                @endif
                            @endif
                        </a>
                    </th>

                    {{-- Status --}}
                    <th class="px-4 py-2 border text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        @php
                            $statusFilter = request('status');
                            $nextStatus = 'draft';

                            if ($statusFilter === 'draft') {
                                $nextStatus = 'published';
                            } elseif ($statusFilter === 'published') {
                                $nextStatus = null; // klik ke-3 = reset
                            }
                        @endphp

                        <a href="{{ $nextStatus 
                            ? route('author.posts.index', [
                                'status' => $nextStatus,
                                'sort' => request('sort'),
                                'direction' => request('direction'),
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                            : route('author.posts.index', [
                                'sort' => request('sort'),
                                'direction' => request('direction'),
                                'category' => request('category'),
                                'search' => request('search')
                            ]) 
                        }}" 
                        class="flex items-center space-x-1 hover:text-blue-600">
                            <span>Status</span>
                            @if($statusFilter)
                                @if($statusFilter === 'draft')
                                    <span>▲</span>
                                @elseif($statusFilter === 'published')
                                    <span>▼</span>
                                @endif
                            @endif
                        </a>
                    </th>

                    {{-- Actions --}}
                    <th class="px-4 py-2 border text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-4 py-2 border text-sm font-medium text-gray-900">
                            {{ $post->title }}
                        </td>
                        <td class="px-4 py-2 border text-sm text-gray-600">
                            {{ $post->category->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 border text-sm text-gray-500">
                            {{ $post->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-2 border text-sm">
                            @if($post->status === 'draft')
                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">Draft</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Published</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border text-sm text-gray-500 justify-end items-center space-x-2">
                            <div class="hidden sm:flex gap-2 justify-end">
                                <a href="{{ route('author.posts.show', $post) }}" 
                                class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                                <a href="{{ route('author.posts.edit', $post) }}" 
                                class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('author.posts.destroy', $post) }}" method="POST" 
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </div>

                            <!-- Mobile Dropdown -->
                            <div x-data="{ open: false }" class="sm:hidden relative flex max-w-xs items-center">
                                <button @click="open = !open" 
                                        class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">⋮</button>
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-10">
                                    <a href="{{ route('author.posts.show', $post) }}" 
                                       class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">View</a>
                                    <a href="{{ route('author.posts.edit', $post) }}" 
                                       class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                    <form action="{{ route('author.posts.destroy', $post) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full text-left px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 text-sm">
                            No articles yet. Start writing!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</x-layout>
