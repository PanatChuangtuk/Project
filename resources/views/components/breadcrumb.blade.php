<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                @if(!$breadcrumb['active'])
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                @else
                    {{ $breadcrumb['title'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
