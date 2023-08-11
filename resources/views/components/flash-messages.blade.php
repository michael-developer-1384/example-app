@if (session('success'))
    <div class="text-sm text-green-600 dark:text-green-400 space-y-5" style="margin-bottom:15px">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="text-sm text-red-600 dark:text-red-400 space-y-5" style="margin-bottom:15px">
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div class="text-sm text-red-600 dark:text-red-400 space-y-5" style="margin-bottom:15px">
        {{ session('warning') }}
    </div>
@endif
