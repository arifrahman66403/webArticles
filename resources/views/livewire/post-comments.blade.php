<div>
    {{-- Form komentar utama --}}
    <form wire:submit.prevent="addComment" class="mb-6">
        <textarea wire:model.defer="body" rows="2"
            class="w-full border rounded-lg p-3 text-sm focus:ring focus:ring-blue-200"
            placeholder="Tulis komentar..."></textarea>

        @if($parentId)
            <p class="text-xs text-gray-500 mt-1">
                Membalas komentar: 
                <span class="font-semibold">
                    {{ \App\Models\User::find($replyTo)?->name }}
                </span>
                <button type="button" wire:click="$set('parentId', null); $set('replyTo', null)" 
                        class="text-red-500 ml-2 hover:underline">
                    batal
                </button>
            </p>
        @endif

        <button type="submit"
            class="mt-2 px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
            Kirim
        </button>
    </form>

    {{-- Daftar komentar --}}
    <div class="space-y-4">
        @foreach($comments as $comment)
            <x-livewire.comment :comment="$comment" />
        @endforeach
    </div>
</div>
