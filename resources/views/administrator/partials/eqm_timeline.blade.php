@php
    $actionColor = [
        'request' => '#6c757d',
        'approve_borrow' => '#0d6efd',
        'overdue' => '#dc3545',
        'return_request' => '#0dcaf0',
        'approve_return' => '#198754',
        'reject_return' => '#fd7e14',
        'cancel' => '#212529',
    ];
    // เหตุการณ์ระดับชิ้นที่เกิดพร้อมกัน (เช่น อนุมัติ 3 ชิ้นในครั้งเดียว) รวมเป็นรายการเดียว
    $events = $borrow->histories
        // เรียงตาม id: เหตุการณ์ถูกบันทึกตามลำดับที่เกิด (ข้อมูลที่ย้ายมาไม่มีเวลา แต่ id ยังเรียงตามขั้นตอน)
        ->sortBy('id')
        ->groupBy(
            fn($h) => $h->action .
                '|' .
                ($h->created_at?->format('Y-m-d H:i:s') ?? 'unknown') .
                '|' .
                $h->admin_id .
                '|' .
                $h->member_id,
        );
@endphp
<style>
    .eqm-timeline {
        list-style: none;
        margin: 0;
        padding: 0 0 0 8px;
    }

    .eqm-timeline li {
        position: relative;
        padding: 0 0 20px 28px;
        border-left: 2px solid #e5e7eb;
    }

    .eqm-timeline li:last-child {
        border-left-color: transparent;
        padding-bottom: 0;
    }

    .eqm-timeline .dot {
        position: absolute;
        left: -8px;
        top: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #d1d5db;
    }

    .eqm-timeline .title {
        font-weight: 600;
        font-size: 1rem;
    }

    .eqm-timeline .meta {
        color: #6b7280;
        font-size: .875rem;
    }

    .eqm-timeline .items {
        margin-top: 4px;
        font-size: .9rem;
    }
</style>
<div class="card p-4 mt-4">
    <h4 class="display-4 mb-4">ประวัติการยืม-คืน</h4>
    @if ($events->isEmpty())
        <p class="text-muted mb-0">ยังไม่มีประวัติ</p>
    @else
        <ul class="eqm-timeline">
            @foreach ($events as $group)
                @php
                    $first = $group->first();
                    $items = $group->whereNotNull('detail_id');
                @endphp
                <li>
                    <span class="dot" style="background: {{ $actionColor[$first->action] ?? '#6c757d' }}"></span>
                    <div class="title" style="color: {{ $actionColor[$first->action] ?? '#6c757d' }}">
                        {{ $first->actionLabel() }}</div>
                    <div class="meta">
                        {{ $first->created_at ? $first->created_at->setTimezone('Asia/Bangkok')->locale('th')->translatedFormat('d M Y H:i') . ' น.' : 'ไม่ทราบเวลา' }}
                        · โดย {{ $first->actorLabel() }}
                    </div>
                    @if ($items->isNotEmpty())
                        <div class="items">
                            @foreach ($items as $event)
                                <div>
                                    {{ $event->detail?->name ?? '-' }}
                                    @if ($event->equipment_id)
                                        <span class="text-muted">หมายเลข
                                            {{ $event->equipment?->number ?? $event->equipment_id }}</span>
                                    @endif
                                    @if ($event->condition)
                                        —
                                        <strong>{{ \App\Models\EqmHistoryDetail::CONDITIONS[$event->condition] ?? $event->condition }}</strong>
                                    @endif
                                    @if ($event->note)
                                        <span class="text-muted">({{ $event->note }})</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @elseif ($first->note)
                        <div class="items text-muted">{{ $first->note }}</div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
