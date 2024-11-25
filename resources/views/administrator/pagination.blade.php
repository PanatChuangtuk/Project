@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center mb-2 mx-3 mt-4">
        <div class="text-muted">
            <p class="small">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        {{-- Pagination placed on the right --}}
        <div class="d-flex justify-content-end flex-fill">
            <ul class="pagination">
                {{-- First Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')">&laquo;</a>
                    </li>
                @endif

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $current = $paginator->currentPage();
                    $total = $paginator->lastPage();
                    
                    $start = max(1, $current - 2);
                    $end = min($total, $current + 2);

                    if ($current < 4) {
                        $start = 1;
                        $end = min(5, $total);
                    } elseif ($current >= $total - 2) {
                        $start = max($total - 4, 1);
                        $end = $total;
                    }
                @endphp

                {{-- "Three Dots" Separator for start --}}
                @if ($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                    </li>
                    @if ($start > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                {{-- Pagination Range --}}
                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $current)
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endfor

                {{-- "Three Dots" Separator for end --}}
                @if ($end < $total)
                    @if ($end < $total - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($total) }}">{{ $total }}</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&rsaquo;</span>
                    </li>
                @endif

                {{-- Last Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="@lang('pagination.last')">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
