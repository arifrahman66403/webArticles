<div>
    <button wire:click="toggleLike" 
        class="flex items-center gap-1 transition
        {{ $liked ? 'text-red-500 hover:text-red-600' : 'text-gray-500 hover:text-red-500' }}">
        
        @if($liked)
            <!-- Heart Solid -->
            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" 
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                       2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 
                       4.5 2.09C13.09 3.81 14.76 3 16.5 3 
                       19.58 3 22 5.42 22 8.5c0 3.78-3.4 
                       6.86-8.55 11.54L12 21.35z"/>
            </svg>
        @else
            <!-- Heart Outline -->
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 
                         7.636l1.318-1.318a4.5 4.5 0 116.364 
                         6.364L12 21.364l-7.682-7.682a4.5 
                         4.5 0 010-6.364z" />
            </svg>
        @endif

        <span>{{ $likesCount }}</span>
    </button>
</div>
