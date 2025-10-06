<div 
    x-data="{ show: false, type: '', message: '' }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-5 right-5 z-50 w-80 rounded-lg shadow-lg"
    :class="{
        'bg-green-100 border border-green-300 text-green-700': type === 'success',
        'bg-red-100 border border-red-300 text-red-700': type === 'error'
    }"
    @notify.window="
        type = $event.detail.type;
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 5000);
    "
    x-init="
        @if(session('success'))
            type = 'success';
            message = '{{ session('success') }}';
            show = true;
            setTimeout(() => show = false, 5000);
        @elseif(session('error'))
            type = 'error';
            message = '{{ session('error') }}';
            show = true;
            setTimeout(() => show = false, 5000);
        @endif
    "
>
    <div class="p-4 flex items-start gap-3">
        <div class="flex-shrink-0">
            <template x-if="type === 'success'">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </template>
        </div>
        <div class="flex-1">
            <p class="font-semibold" x-text="type === 'success' ? 'Success' : 'Error'"></p>
            <p class="text-sm" x-text="message"></p>
        </div>
        <button @click="show = false" class="text-gray-600 hover:text-gray-800">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
