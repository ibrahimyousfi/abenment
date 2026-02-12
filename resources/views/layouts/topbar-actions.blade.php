<div class="flex flex-row justify-between items-center gap-2 w-full">
    <!-- Search Field -->
    <div class="flex-1 max-w-lg">
        <form method="GET" action="{{ url()->current() }}" class="w-full relative flex items-center" id="topbar-search-form">
            <!-- Preserve existing query parameters -->
            @foreach(request()->except(['search', 'q', 'page']) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $v)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') ?? request('q') }}"
                       placeholder="{{ $searchPlaceholder ?? 'Rechercher...' }}"
                       class="w-full pl-9 pr-4 py-1.5 rounded-md border-gray-300 bg-gray-50 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition-all placeholder-gray-400"
                       id="topbar-search-input">
            </div>
        </form>
    </div>

    <!-- Add New Button -->
    @if(isset($addRoute))
    <div class="flex-shrink-0 ml-2">
        <a href="{{ route($addRoute, $addRouteParams ?? []) }}"
           class="inline-flex justify-center items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-md shadow-sm transition duration-150 gap-1.5 whitespace-nowrap">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden sm:inline">{{ $addButtonLabel ?? 'Ajouter' }}</span>
            <span class="sm:hidden">Ajouter</span>
        </a>
    </div>
    @endif
</div>

<script>
    // Script to clean query string on submit
    if (!window.topbarScriptLoaded) {
        window.topbarScriptLoaded = true;
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'topbar-search-form') {
                const input = e.target.querySelector('input[name="search"]');
                if (input && !input.value.trim()) {
                    e.preventDefault();
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    url.searchParams.delete('q');
                    window.location.href = url.toString();
                }
            }
        });
    }
</script>
