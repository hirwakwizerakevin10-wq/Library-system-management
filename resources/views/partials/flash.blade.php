@if (session('success'))
    <div class="mb-5 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-200" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
        <span class="flex-1 font-medium">{{ session('success') }}</span>
        <button @click="show = false" class="shrink-0 opacity-60 transition hover:opacity-100">&times;</button>
    </div>
@endif
@if (session('error'))
    <div class="mb-5 flex items-center gap-3 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-200" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        <span class="flex-1 font-medium">{{ session('error') }}</span>
        <button @click="show = false" class="shrink-0 opacity-60 transition hover:opacity-100">&times;</button>
    </div>
@endif
@if ($errors->any())
    <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-200">
        <div class="mb-1 font-semibold">Please fix the highlighted fields.</div>
        <ul class="list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
