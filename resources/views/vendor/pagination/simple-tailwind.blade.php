@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="nsfwhen-pagination" style="justify-content: space-between;">
        @if ($paginator->onFirstPage())
            <span class="nsfwhen-page-item disabled" aria-disabled="true">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="nsfwhen-page-item">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="nsfwhen-page-item">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="nsfwhen-page-item disabled" aria-disabled="true">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
