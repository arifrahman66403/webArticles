<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  {{-- About Us Section --}}
  <div class="py-10 px-4 mx-auto max-w-screen-xl lg:px-6">
    <div class="text-center mb-10">
      <h1 class="text-5xl font-bold text-gray-800 dark:text-white mb-4">About Us</h1>
      <p class="text-gray-600 dark:text-gray-400 max-w-xl mx-auto">
        We are a team of passionate developers dedicated to building high-quality web applications using Laravel and modern technologies.
      </p>
    </div>

    <div class="text-center mb-10">
      <h2 class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">Our Mission</h2>
      <p class="mt-2 text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        To create innovative and user-friendly web solutions that empower businesses and individuals.
      </p>
    </div>

    <div class="mt-12">
      <h2 class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400 text-center mb-6">Our Team</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($users as $user)
        <a href="/about/{{ $user['username'] }}">
          <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition duration-300 ease-in-out text-center transition-transform duration-300 hover:scale-110">
            <img class="h-24 w-24 rounded-full object-cover mx-auto mb-4 border-4 border-indigo-100 dark:border-indigo-500"
                 src="{{ $user->profile_photo_url ?? 'https://i.pravatar.cc/300?u=' . urlencode($user->id) }}" alt="{{ $user->name }}" />
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $user->name }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ $user->username }}</p>
            <div class="mt-3">
              <span class="inline-block bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-white text-xs font-medium px-3 py-1 rounded-full">
                {{ $user->alias_role }}
              </span>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Footer --}}
  <div class="py-6 px-4 mt-12 bg-gray-50 dark:bg-gray-900">
    <div class="text-center">
      <p class="text-sm text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
    </div>
  </div>
</x-layout>