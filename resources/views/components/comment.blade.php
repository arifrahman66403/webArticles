@props(['comment', 'level' => 0])

<div class="flex gap-3 py-3 border-b border-gray-100 text-sm">
    <!-- Profile Photo -->
    <img src="{{ $comment->user->profile_photo_url }}"
         alt="{{ $comment->user->name }}"
         class="w-8 h-8 rounded-full object-cover flex-shrink-0">

    <div class="flex-1">
        <!-- Header (Name + Time) -->
        <div class="flex items-center gap-2">
            <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
        </div>

        <!-- Indikator Reply -->
        @if($comment->reply_to && $comment->replyToUser)
            <span class="text-xs text-indigo-600">- Replying to {{ $comment->replyToUser->name }}</span>
        @endif

        <!-- Body -->
        <p class="text-gray-700 mt-1">{{ $comment->body }}</p>

        <!-- Actions -->
        <div class="mt-1 flex items-center gap-4 text-xs text-gray-500">
            <button type="button"
                onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')"
                class="hover:underline">
                Reply
            </button>

            @if($comment->replies->count())
                <button type="button"
                    onclick="document.getElementById('replies-{{ $comment->id }}').classList.toggle('hidden')"
                    class="hover:underline">
                    {{ $comment->replies->count() }} Replies
                </button>
            @endif
            @can('delete', $comment)
                <form action="{{ route('comments.delete', $comment->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this comment?')"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="hover:underline text-red-500">Delete</button>
                </form>
            @endcan
        </div>

        <!-- Reply Form -->
        <form action="{{ route('comments.store', $comment->post_id) }}" method="POST"
              id="reply-form-{{ $comment->id }}" class="hidden mt-2">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input type="hidden" name="reply_to" value="{{ $comment->user_id }}">
            <textarea name="body" rows="1"
                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"
                placeholder="Write a reply..."></textarea>
            <button type="submit"
                class="mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">
                Reply
            </button>
        </form>

        <!-- Nested Replies -->
        @if($comment->replies->count() && $level < 2)
            <div id="replies-{{ $comment->id }}" class="hidden mt-3 pl-6 border-l border-gray-200 space-y-2">
                @foreach($comment->replies as $reply)
                    {{-- Rekursi akan berhenti saat komentar sudah punya parent_id --}}
                    @if(is_null($reply->parent_id))
                        <x-comment :comment="$reply" :level="$level + 1" />
                    @else
                        <!-- Tampilkan flat -->
                        <div class="flex gap-2">
                            <img src="{{ $reply->user->profile_photo_url }}"
                                 alt="{{ $reply->user->name }}"
                                 class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                            <div>
                                <span class="font-semibold text-gray-800">{{ $reply->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                {{-- Tambahkan cek untuk replyToUser di level ini --}}
                                @if($reply->replyToUser)
                                    <span class="text-xs text-indigo-600">- Replying to {{ $reply->replyToUser->name }}</span>
                                @endif
                                <p class="text-gray-700 text-sm mt-1">{{ $reply->body }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
