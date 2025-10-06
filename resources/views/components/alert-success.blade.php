@if (session('success'))
<div 
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-init="setTimeout(() => show = false, 5000)"
    class="fixed top-5 right-5 z-50 w-80 rounded-lg bg-green-100 border border-green-300 shadow-lg"
>
    <div class="p-4 flex items-start gap-3">
        <div class="flex-shrink-0">
            <!-- Icon centang -->
            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-green-800">Success</p>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        <button 
            @click="show = false" 
            class="text-green-600 hover:text-green-800"
        >
            <span class="sr-only">Close</span>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
<!-- <div 
  id="flash-message"
  class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-4"
  role="alert"
>
  <strong class="font-bold">Success!</strong>
  <span class="block sm:inline">{{ session('success') }}</span>
</div>

<script>
  setTimeout(() => {
    const flash = document.getElementById('flash-message');
    if (flash) {
      flash.style.display = 'none';
    }
  }, 5000); // 5 detik
</script> -->
@endif