<x-layoutadmin>
    <div class="p-6 space-y-6">
        <h1 class="text-2xl font-semibold mb-4">Inbox Message</h1>

        <x-alert-success />

        {{-- Filter Tab --}}
        <div class="flex gap-2 mb-4">
            <a href="{{ route('message.index', ['filter'=>'all']) }}"
               class="px-4 py-2 rounded-lg border {{ $filter=='all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
               All
            </a>
            <a href="{{ route('message.index', ['filter'=>'unread']) }}"
               class="px-4 py-2 rounded-lg border {{ $filter=='unread' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
               Unread
            </a>
            <a href="{{ route('message.index', ['filter'=>'read']) }}"
               class="px-4 py-2 rounded-lg border {{ $filter=='read' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
               Read
            </a>
        </div>

        {{-- List Pesan --}}
        <div class="rounded-xl border bg-white dark:bg-gray-800 shadow">
            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-3 border-b dark:border-gray-700">
                <h2 class="font-semibold text-lg">All Message</h2>

                @if($messages->count() > 0)
                    <form action="{{ route('message.destroyAll') }}" method="POST" 
                        onsubmit="return confirm('Are you sure you want to delete all message?')">
                        @csrf @method('DELETE')
                        <button class="px-4 py-2 text-sm font-medium bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                            Delete All
                        </button>
                    </form>
                @endif
            </div>

            {{-- Messages --}}
            <ul class="divide-y dark:divide-gray-700">
                @forelse($messages as $message)
                    <li class="px-5 py-4 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition" x-data="{ open:false }">
                        <div class="max-w-md">
                            <h2 class="font-semibold {{ $message->is_read ? 'text-gray-600' : 'text-green-600' }}">
                                {{ $message->name }}
                            </h2>
                            <p class="text-sm text-gray-500">{{ $message->email }}</p>
                            <p class="text-sm mt-1 line-clamp-1">{{ $message->message }}</p>
                            <p class="text-xs text-gray-400 mt-1">Date: {{ $message->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('message.show', $message->email) }}" 
                               class="px-3 py-1 rounded-md border text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                More detail
                            </a>
                            <button @click="open=true" 
                                    class="px-3 py-1 rounded-md border text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                View
                            </button>
                            <form action="{{ route('message.destroy', $message->email) }}" method="POST"
                                onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 rounded-md bg-red-600 text-white text-sm hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>

                        {{-- Modal --}}
                        <div x-show="open" x-cloak 
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-lg p-6 mx-4"
                                 @click.away="open=false" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-90"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-90"
                            >
                                <h2 class="text-lg font-semibold mb-2">Message from "{{ $message->name }}"</h2>
                                <p class="text-sm text-gray-500">Email: {{ $message->email }}</p>
                                <div class="mt-4 text-gray-700 dark:text-gray-200 max-h-60 sm:max-h-80 overflow-y-auto pr-2">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                                <p class="text-xs text-gray-400 mt-4">Received: {{ $message->created_at->format('d M Y, H:i') }}</p>

                                <div class="flex justify-end gap-2 mt-6">
                                    @if(!$message->is_read)
                                        <form action="{{ route('message.read', $message->email) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                    <button @click="open=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-5 py-6 text-gray-500 text-center">No message found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layoutadmin>