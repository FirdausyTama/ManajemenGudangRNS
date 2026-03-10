@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center items-center gap-4 my-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center justify-center text-gray-300 cursor-not-allowed transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center text-gray-500 hover:text-rns-blue transition-all transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex items-center gap-4">
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex items-center justify-center text-xl text-gray-400 mx-1">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex items-center justify-center text-2xl md:text-3xl mx-1 font-black text-rns-blue drop-shadow-[0_2px_8px_rgba(30,58,138,0.5)] transform scale-110 transition-all cursor-default" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="flex items-center justify-center text-xl md:text-2xl mx-1 font-bold text-gray-400 hover:text-blue-500 transition-all transform hover:scale-110">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center text-gray-500 hover:text-rns-blue transition-all transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="flex items-center justify-center text-gray-300 cursor-not-allowed transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </nav>
@endif
