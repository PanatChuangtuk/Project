@props(['status', 'item'])

<div class="status-container">
    @if (in_array(strtolower($status), ['completed', 'cancel']))
        <span class="status-badge {{ strtolower($status) }}">
            @if (strtolower($status) == 'completed')
                อนุมัติ
            @elseif (strtolower($status) == 'cancel')
                ยกเลิก
            @endif
        </span>
    @else
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                id="dropdownMenuButton{{ $item }}" data-bs-toggle="dropdown" aria-expanded="false"
                style="font-size: 14px;">
                @if (strtolower($status) == 'in_progress')
                    รอดำเนินการ
                @else
                    {{ ucfirst($status) }}
                @endif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item }}">
                <li><a class="dropdown-item" data-item="{{ $item }}" data-status="in_progress"
                        style="font-size: 14px;">รอดำเนินการ</a></li>
                <li><a class="dropdown-item" data-item="{{ $item }}" data-status="completed"
                        style="font-size: 14px;">อนุมัติ</a></li>
                <li><a class="dropdown-item" data-item="{{ $item }}" data-status="cancel"
                        style="font-size: 14px;">ยกเลิก</a></li>
            </ul>
        </div>
    @endif
</div>
{{-- @props(['status', 'item'])

<div class="dropdown">
    <button
        class="btn w-10 btn-{{ strtolower($status) == 'approve' ? '' : (strtolower($status) == 'cancel' ? '' : '') }} dropdown-toggle"
        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 14px;">
        @if (strtolower($status) == 'completed')
            อนุมัติ
        @elseif (strtolower($status) == 'in_progress')
            รอดำเนินการดำเนินการ
        @elseif(strtolower($status) == 'cancel')
            ยกเลิก
        @endif
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

        <li><a class="dropdown-item" data-item="{{ $item }}" data-status="in_progress"
                style="font-size: 14px;">รอดำเนินการดำเนินการ</a></li>
        <li><a class="dropdown-item" data-item="{{ $item }}" data-status="completed"
                style="font-size: 14px;">อนุมัติ</a></li>
        <li><a class="dropdown-item" data-item="{{ $item }}" data-status="cancel"
                style="font-size: 14px;">ยกเลิก</a>
        </li>

    </ul>
</div> --}}
