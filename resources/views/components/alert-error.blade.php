@if ($errors->any() || session('error'))
<div 
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-init="setTimeout(() => show = false, 8000)"
    class="fixed top-5 right-5 z-50 w-80 animate-shake rounded-lg bg-red-100 border border-red-300 shadow-lg"
>
    <div class="p-4 flex items-start gap-3">
        <div class="flex-shrink-0">
            <!-- Icon tanda seru -->
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
        </div>

        <div class="flex-1">
            <p class="font-semibold text-red-800">Error</p>

            @if (session('error'))
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            @endif

            @if ($errors->any())
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <button 
            @click="show = false" 
            class="text-red-600 hover:text-red-800"
        >
            <span class="sr-only">Close</span>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<style>
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%      { transform: translateX(-15px); }
  40%      { transform: translateX(15px); }
  60%      { transform: translateX(-15px); }
  80%      { transform: translateX(15px); }
}
.animate-shake {
  animation: shake 0.4s ease-in-out;
}
</style>
<!-- <style>
@keyframes shake {
  0%, 100%   { transform: translate(0, 0); }
  20%        { transform: translate(-20px, -9px); }
  40%        { transform: translate(20px, 9px); }
  60%        { transform: translate(-20px, 6px); }
  80%        { transform: translate(20px, -6px); }
}
.animate-shake {
  animation: shake 0.5s ease-in-out;
}
</style> -->
@endif