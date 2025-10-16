<div class="mt-6" x-data="{ openReply: null }">
    {{-- Form komentar utama --}}
    <form wire:submit.prevent="postComment" class="mb-5">
        <textarea
            wire:model.defer="newComment"
            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"
            placeholder="Write a comment..."></textarea>

        <button
            type="submit"
            class="mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">
            Comment
        </button>
    </form>

    {{-- Daftar komentar --}}
    @foreach ($comments as $comment)
        <div class="flex gap-3 py-3 border-b border-gray-100 text-sm">
            <img src="{{ $comment->user->profile_photo_url }}"
                 alt="{{ $comment->user->name }}"
                 class="w-8 h-8 rounded-full object-cover">

            <div class="flex-1">
                {{-- Header --}}
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                @if ($comment->reply_to && $comment->replyToUser)
                    <span class="text-xs text-indigo-600">- Replying to {{ $comment->replyToUser->name }}</span>
                @endif

                <p class="text-gray-700 mt-1">{{ $comment->body }}</p>

                {{-- Aksi --}}
                <div class="mt-1 flex items-center gap-4 text-xs text-gray-500">
                    <button
                        @click="openReply = openReply === {{ $comment->id }} ? null : {{ $comment->id }}"
                        class="hover:underline">
                        Reply
                    </button>

                    @if ($comment->replies->count())
                        <span>{{ $comment->replies->count() }} Replies</span>
                    @endif

                    @if ($comment->user_id === auth()->id())
                        <button
                            wire:click="deleteComment({{ $comment->id }})"
                            onclick="confirm('Delete this comment?') || event.stopImmediatePropagation()"
                            class="hover:underline text-red-500">
                            Delete
                        </button>
                    @endif
                </div>

                {{-- Form reply --}}
                <div x-show="openReply === {{ $comment->id }}" x-transition>
                    <form wire:submit.prevent="postComment({{ $comment->id }}, {{ $comment->user_id }})" class="mt-2">
                        <textarea
                            wire:model.defer="replyBodies.{{ $comment->id }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"
                            placeholder="Write a reply..."></textarea>

                        <div class="mt-2 flex gap-2">
                            <button
                                type="button"
                                @click="openReply = null"
                                class="px-3 py-1 text-gray-500 border rounded-lg text-xs hover:bg-gray-50">
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">
                                Reply
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Replies --}}
                @if ($comment->replies->count())
                    <div class="mt-3 pl-6 border-l border-gray-200 space-y-2">
                        @foreach ($comment->replies as $reply)
                            <div class="flex gap-2">
                                <img src="{{ $reply->user->profile_photo_url }}"
                                     alt="{{ $reply->user->name }}"
                                     class="w-7 h-7 rounded-full object-cover">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-800">{{ $reply->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>

                                    @if ($reply->replyToUser)
                                        <span class="text-xs text-indigo-600">- Replying to {{ $reply->replyToUser->name }}</span>
                                    @endif

                                    <p class="text-gray-700 text-sm mt-1">{{ $reply->body }}</p>

                                    <div class="mt-1 flex items-center gap-4 text-xs text-gray-500">
                                        <button
                                            @click="openReply = openReply === {{ $reply->id }} ? null : {{ $reply->id }}"
                                            class="hover:underline">
                                            Reply
                                        </button>

                                        @if ($reply->user_id === auth()->id())
                                            <button
                                                wire:click="deleteComment({{ $reply->id }})"
                                                onclick="confirm('Delete this reply?') || event.stopImmediatePropagation()"
                                                class="hover:underline text-red-500">
                                                Delete
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Nested reply form --}}
                                    <div x-show="openReply === {{ $reply->id }}" x-transition>
                                        <form wire:submit.prevent="postComment({{ $reply->id }}, {{ $reply->user_id }})" class="mt-2">
                                            <textarea
                                                wire:model.defer="replyBodies.{{ $reply->id }}"
                                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"
                                                placeholder="Write a reply..."></textarea>

                                            <div class="mt-2 flex gap-2">
                                                <button
                                                    type="button"
                                                    @click="openReply = null"
                                                    class="px-3 py-1 text-gray-500 border rounded-lg text-xs hover:bg-gray-50">
                                                    Cancel
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">
                                                    Reply
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
