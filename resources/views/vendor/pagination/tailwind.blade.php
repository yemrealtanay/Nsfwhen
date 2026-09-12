@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="nsfwhen-pagination">
        {{-- Results Info --}}
        <div class="nsfwhen-pagination-info">
            @if(app()->getLocale() === 'tr')
                @if ($paginator->firstItem())
                    <strong>{{ $paginator->total() }}</strong> sonuçtan <strong>{{ $paginator->firstItem() }}</strong> - <strong>{{ $paginator->lastItem() }}</strong> arası
                @else
                    <strong>{{ $paginator->count() }}</strong> sonuç
                @endif
            @else
                Showing
                @if ($paginator->firstItem())
                    <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong>
                @else
                    <strong>{{ $paginator->count() }}</strong>
                @endif
                of <strong>{{ $paginator->total() }}</strong> results
            @endif
        </div>

        {{-- Page Buttons --}}
        <div class="nsfwhen-pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="nsfwhen-page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14" style="width: 14px; height: 14px; display: inline-block;">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="nsfwhen-page-item" aria-label="{{ __('pagination.previous') }}">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14" style="width: 14px; height: 14px; display: inline-block;">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="nsfwhen-page-dots" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="nsfwhen-page-item active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="nsfwhen-page-item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="nsfwhen-page-item" aria-label="{{ __('pagination.next') }}">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14" style="width: 14px; height: 14px; display: inline-block;">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span class="nsfwhen-page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14" style="width: 14px; height: 14px; display: inline-block;">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
