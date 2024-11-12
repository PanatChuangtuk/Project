@if ($items->lastPage() > 1)
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link arrow prev" href="{{ $items->previousPageUrl() }}">
                <img class="icons svg-js" src="{{ asset('img/icons/icon-next.svg') }}" alt="">
            </a>
        </li>

        @for ($i = 1; $i <= $items->lastPage(); $i++)
            <li class="page-item {{ $i == $items->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $items->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <li class="page-item">
            <a class="page-link arrow next" href="{{ $items->nextPageUrl() }}">
                <img class="icons svg-js" src="{{ asset('img/icons/icon-next.svg') }}" alt="">
            </a>
        </li>
    </ul>
@endif
