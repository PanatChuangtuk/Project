@php
    $cart = session('cart', []);
@endphp

@extends('main')

@section('title')
    Equipment Management
@endsection
@section('stylesheet')
    <style>
        .equipment-item {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            background: #fff;
            transition: box-shadow 0.2s ease;
            text-align: center;
        }

        .equipment-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .equipment-img {
            width: 100px;
            max-height: 180px;
            object-fit: contain;
            margin-bottom: 12px;
            border-radius: 8px;
        }

        .equipment-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .btn-add-cart {
            margin-top: 8px;
            width: 100%;
            background: #89a082;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .btn-add-cart:hover {
            background: #1e3e2f;
        }

        .btn-add-cart:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2e4e3f;
            margin-bottom: 25px;
            border-left: 5px solid #89a082;
            padding-left: 15px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px 0;
        }

        .quantity-btn {
            background: #e0e0e0;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #c0c0c0;
        }

        .quantity-display {
            width: 50px;
            text-align: center;
            font-weight: bold;
            margin: 0 10px;
        }

        .quantity-btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .available-quantity {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
        }

        .available-quantity span {
            font-weight: bold;
            color: #2e4e3f;
        }

        .out-of-stock {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="section section-profile bg-light py-5">
        <div class="container">
            <h2 class="section-title">รายการอุปกรณ์</h2>
            <div class="row">
                @foreach ($equipment as $item)
                    @php
                        $totalStock = $item->equipment->count();
                        $borroweds = $borrowedCounts[$item->id] ?? 0;
                        $borrowed = isset($cart[$item->id]) ? $cart[$item->id]['quantity'] : 0;
                        $available = max($totalStock - $borrowed - $borroweds, 0);
                    @endphp

                    <div class="col-md-4">
                        <div class="equipment-item">
                            <img src="{{ $item->image ? asset('upload/file/equipment_item/' . $item->image) : asset('images/default-image.png') }}"
                                class="equipment-img" alt="{{ $item->name }}">

                            <div class="equipment-name">{{ $item->name }}</div>

                            <div class="available-quantity">
                                @if ($available > 0)
                                    อุปกรณ์คงเหลือ : <span>{{ $available }}</span> ชิ้น
                                @else
                                    <span class="out-of-stock">ไม่มีอุปกรณ์ให้ยืม</span>
                                @endif
                            </div>

                            <div class="quantity-control">
                                <button class="quantity-btn btn-decrease quantity-btn-disabled"
                                    data-id="{{ $item->id }}">-</button>
                                <div class="quantity-display" id="quantity-{{ $item->id }}">0</div>
                                <button
                                    class="quantity-btn btn-increase {{ $available <= 0 ? 'quantity-btn-disabled' : '' }}"
                                    data-id="{{ $item->id }}" data-max="{{ $available }}">+</button>
                            </div>

                            <button class="btn-add-cart" data-id="{{ $item->id }}"
                                {{ $available <= 0 ? 'disabled' : '' }}>
                                ขอยืมอุปกรณ์
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let quantities = {};

            $('.btn-decrease').each(function() {
                let id = $(this).data('id');
                quantities[id] = 0;
            });

            $('.btn-increase').click(function() {
                if ($(this).hasClass('quantity-btn-disabled')) return;

                let id = $(this).data('id');
                let maxQuantity = parseInt($(this).data('max'));

                if (quantities[id] < maxQuantity) {
                    quantities[id]++;
                    updateQuantityDisplay(id, maxQuantity);
                }
            });

            $('.btn-decrease').click(function() {
                if ($(this).hasClass('quantity-btn-disabled')) return;

                let id = $(this).data('id');
                let maxQuantity = $(`.btn-increase[data-id="${id}"]`).data('max');

                if (quantities[id] > 0) {
                    quantities[id]--;
                    updateQuantityDisplay(id, maxQuantity);
                }
            });

            $('.btn-add-cart').click(function() {
                let id = $(this).data('id');
                let quantity = quantities[id];

                if (quantity <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกจำนวนอุปกรณ์',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                $.ajax({
                    url: 'equipment-list/cart',
                    type: 'POST',
                    data: {
                        equipment_id: id,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'เพิ่มอุปกรณ์ลงตะกร้าเรียบร้อยเรียบร้อย',

                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                quantities[id] = 0;
                                updateQuantityDisplay(id, parseInt($(
                                    `.btn-increase[data-id="${id}"]`).data(
                                    'max')) - quantity);
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: response.message,
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เชื่อมต่อล้มเหลว',
                            text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                            confirmButtonText: 'ตกลง'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });

            function updateQuantityDisplay(id, maxQuantity) {
                $(`#quantity-${id}`).text(quantities[id]);

                if (quantities[id] === 0) {
                    $(`.btn-decrease[data-id="${id}"]`).addClass('quantity-btn-disabled');
                    $(`.btn-add-cart[data-id="${id}"]`).prop('disabled', true);
                } else {
                    $(`.btn-decrease[data-id="${id}"]`).removeClass('quantity-btn-disabled');
                    $(`.btn-add-cart[data-id="${id}"]`).prop('disabled', false);
                }

                if (quantities[id] >= maxQuantity) {
                    $(`.btn-increase[data-id="${id}"]`).addClass('quantity-btn-disabled');
                } else {
                    $(`.btn-increase[data-id="${id}"]`).removeClass('quantity-btn-disabled');
                }
            }
        });
    </script>
@endsection
