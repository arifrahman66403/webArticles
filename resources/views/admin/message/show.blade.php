<x-layoutadmin>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Message Details</h1>

        <div class="bg-white shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">
                        Sender Information
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Details of the message sent through the contact form.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs {{ $message->is_read ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' }} px-2 py-1 rounded-md">
                        {{ $message->is_read ? 'Read' : 'Unread' }}
                    </span>

                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                        Sent: {{ $message->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $message->name }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $message->email }}
                        </dd>
                    </div>

                    <div 
                        x-data="{ expanded: false }" 
                        class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">Message</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div 
                                class="bg-gray-100 border border-gray-200 rounded-lg shadow-sm px-4 py-3 leading-relaxed font-medium text-gray-800"
                            >
                                <div 
                                    x-bind:class="expanded ? '' : 'line-clamp-5 overflow-hidden'" 
                                    class="transition-all duration-300 [&>p]:m-0"
                                >
                                    {!! nl2br(e(ltrim($message->message))) !!}
                                </div>

                                <button 
                                    type="button"
                                    @click="expanded = !expanded"
                                    class="mt-2 text-indigo-600 hover:underline text-sm font-semibold"
                                    x-show="$el.previousElementSibling.scrollHeight > $el.previousElementSibling.clientHeight"
                                >
                                    <span x-show="!expanded">Show more</span>
                                    <span x-show="expanded">Show less</span>
                                </button>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-center gap-3">
            <a href="{{ route('message.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </a>

            <div class="flex gap-2">
                @if(!$message->is_read)
                    <form action="{{ route('message.read', $message->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition">
                            Mark as Read
                        </button>
                    </form>
                @endif

                <form action="{{ route('message.destroy', $message->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layoutadmin>