<div
    x-data="{
        show: {{ session('success') || session('error') ? 'true' : 'false' }},
        message: '{{ session('success') ?? session('error') ?? '' }}',
        type: '{{ session('success') ? 'success' : 'error' }}'
    }"
    x-show="show"
    x-init="if (show) setTimeout(() => show = false, 4000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-6 right-6 z-50 max-w-sm"
    style="display: none;"
>
    <div
        :class="type === 'success' ? 'bg-emerald-600' : 'bg-red-600'"
        class="flex items-center gap-3 rounded-xl px-4 py-3 text-white shadow-lg"
    >
        <template x-if="type === 'success'">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </template>
        <p class="text-sm font-medium" x-text="message"></p>
        <button @click="show = false" class="ml-auto shrink-0 opacity-70 hover:opacity-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
