@extends('main')

@section('title')
    Equipment Management
@endsection

@section('stylesheet')
    <style>
        /* ตั้งค่าพื้นฐาน */
        @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #2e4e3f;
            --primary-dark: #243d31;
            --primary-light: #3a6350;
            --secondary: #89a082;
            --secondary-light: #a1b49b;
            --secondary-dark: #718669;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;

            --border-radius-sm: 6px;
            --border-radius: 8px;
            --border-radius-lg: 12px;

            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.05), 0 4px 6px rgba(0, 0, 0, 0.05);

            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* การ์ด */
        .card {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            border: none;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-body {
            padding: 2rem;
        }

        /* ส่วนหัวของหน้า */
        .section-title {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 600;
            ห margin-bottom: 1.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--secondary);
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background-color: var(--primary);
        }

        /* รายการอุปกรณ์ */
        .equipment-item {
            display: flex;
            align-items: center;
            background-color: var(--gray-50);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            border: 1px solid var(--gray-200);
            position: relative;
        }

        .equipment-item:hover {
            transform: translateY(-3px);
            border-color: var(--secondary);
            box-shadow: var(--shadow);
        }

        .equipment-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--secondary);
            border-radius: var(--border-radius) 0 0 var(--border-radius);
        }

        .equipment-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--border-radius);
            margin-right: 1.5rem;
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            background-color: var(--white);
            padding: 0.25rem;
        }

        .equipment-item:hover .equipment-img {
            border-color: var(--secondary);
        }

        .equipment-details {
            flex-grow: 1;
        }

        .equipment-details h5 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .quantity {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: var(--gray-500);
        }

        .quantity-value {
            font-weight: 600;
            color: var(--primary);
            background-color: rgba(137, 160, 130, 0.15);
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            display: inline-block;
        }

        /* Animation for quantity change */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .quantity-highlight {
            animation: pulse 0.6s ease;
            background-color: var(--secondary);
            color: var(--white);
        }

        .stock-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        .stock-info small {
            color: var(--gray-500);
            font-size: 0.85rem;
        }

        .stock-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .status-available {
            background-color: rgba(16, 185, 129, 0.15);
            color: #047857;
        }

        .status-low {
            background-color: rgba(245, 158, 11, 0.15);
            color: #b45309;
        }

        .status-empty {
            background-color: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
        }

        /* ปุ่มดำเนินการ */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-left: 1rem;
        }

        .btn {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 0.5rem;
            cursor: pointer;
            font-family: 'Prompt', sans-serif;
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
        }

        .btn-sm {
            font-size: 1rem;
        }

        .btn-success {
            background-color: #28a745;
            /* เขียวสดใส */
            color: #ffffff;
        }

        .btn-success:hover:not(:disabled) {
            background-color: #218838;
            /* เขียวเข้มขึ้นเมื่อ hover */
        }

        .btn-warning {
            background-color: #ffae00ea;
            /* เหลืองทอง */
            color: #212529;
        }

        .btn-warning:hover:not(:disabled) {
            background-color: #facd45e8;
            /* เหลืองเข้มขึ้น */
        }

        .btn-danger {
            background-color: #dc3545;
            /* แดงสด */
            color: #ffffff;
        }

        .btn-danger:hover:not(:disabled) {
            background-color: #c82333;
            /* แดงเข้มขึ้นเมื่อ hover */
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Loading state */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: calc(50% - 10px);
            left: calc(50% - 10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 0.8s infinite linear;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ตะกร้าว่าง */
        .empty-cart {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-500);
            background-color: var(--gray-50);
            border-radius: var(--border-radius);
            margin: 1.5rem 0;
            /* border: 1px dashed var(--gray-300); */
        }

        .empty-cart i {
            color: var(--secondary);
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .empty-cart h4 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .empty-cart p {
            font-size: 1rem;
            color: var(--gray-500);
        }

        /* กริดแสดงอุปกรณ์ */
        .equipment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        /* รองรับหน้าจอขนาดเล็ก */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .equipment-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem;
            }

            .equipment-img {
                width: 100%;
                height: auto;
                max-height: 150px;
                object-fit: contain;
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .action-buttons {
                margin-left: 0;
                margin-top: 1rem;
                width: 100%;
                justify-content: flex-end;
            }

            .stock-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .stock-status {
                margin-top: 0.25rem;
            }
        }

        /* รองรับหน้าจอขนาดเล็กมาก */
        @media (max-width: 576px) {
            .card-body {
                padding: 1.25rem;
            }

            .section-title {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .equipment-item {
                padding: 0.75rem;
            }

            .btn {
                min-width: 2.25rem;
                height: 2.25rem;
            }
        }

        /* ปุ่มยืม */
        .borrow-button {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin-top: 1.5rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .borrow-button:hover {
            background-color: var(--primary-dark);
        }

        .borrow-button:disabled {
            background-color: var(--gray-300);
            cursor: not-allowed;
        }

        /* เอฟเฟกต์การเข้ามาของรายการ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .equipment-item {
            animation: fadeInUp 0.4s ease-out forwards;
        }

        .btn-borrow {
            background: linear-gradient(90deg, #28a745, #34c759);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-borrow:hover {
            background: linear-gradient(90deg, #218838, #2db44f);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-borrow:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    {{-- <form action="{{ route('borrow.submit') }}" method="POST"> --}}
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="equipment-section">
                    <h2 class="section-title ">การคืนอุปกรณ์</h2>



                    <div class="text-end mt-4 py-5">
                        <button type="submit" class="btn-borrow">
                            <i class="fas fa-check"></i> ยืนยันการคืน
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- </form> --}}
    <div class="equipment-grid py-3">
        <div class="equipment-grid py-1"></div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'สำเร็จ!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'ตกลง'
            }).then(function() {
                window.location.href = '{{ route('profile') }}';
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            let isProcessing = false;

            function updateCart(id, action) {
                if (isProcessing) {
                    return;
                }
                isProcessing = true;
                let clickedButton = $('[data-id="' + id + '"].' + action);
                let originalText = clickedButton.html();
                clickedButton.addClass('loading').prop('disabled', true);
                clickedButton.html('');

                $('[data-id="' + id + '"]').prop('disabled', true);

                $.ajax({
                    url: "{{ route('equipment.update') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        action: action
                    },
                    timeout: 10000,
                    success: function(response) {
                        if (response.success) {
                            if (action === 'remove' || response.quantity <= 0) {
                                $('.equipment-item[data-id="' + id + '"]').fadeOut(300, function() {
                                    $(this).remove();

                                    if ($('.equipment-item').length === 0) {
                                        $('.equipment-section').html(`
                                            <h2 class="section-title">หมวดหมู่อุปกรณ์</h2>
                                            <div class="empty-cart">
                                                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                                <h4>ไม่มีอุปกรณ์ในตะกร้า</h4>
                                                <p>กรุณาเลือกอุปกรณ์ที่ต้องการยืม</p>
                                            </div>
                                            <div class="equipment-grid"></div>
                                        `);
                                    }
                                    Swal.fire({
                                        title: 'ลบอุปกรณ์',
                                        text: 'คุณได้ลบอุปกรณ์ออกจากรายการแล้ว',
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง'
                                    });
                                });
                            } else {
                                let itemDiv = $('.equipment-item[data-id="' + id + '"]');
                                let quantitySpan = itemDiv.find('.quantity-value');
                                let currentQty = parseInt(response.quantity);
                                let available = parseInt(itemDiv.data('available'));
                                let remainingStock = available - currentQty;

                                quantitySpan.text(currentQty);
                                itemDiv.attr('data-borrowed', currentQty);

                                quantitySpan.addClass('quantity-highlight');
                                setTimeout(function() {
                                    quantitySpan.removeClass('quantity-highlight');
                                }, 1000);

                                itemDiv.find('.stock-info small').text('คงเหลือในสต็อก: ' +
                                    remainingStock + ' ชิ้น');

                                itemDiv.find('.increase').prop('disabled', remainingStock <= 0);
                                itemDiv.find('.decrease').prop('disabled', currentQty <= 1);
                            }
                        }
                    },
                    complete: function() {
                        isProcessing = false;
                        clickedButton.removeClass('loading').prop('disabled', false);
                        clickedButton.html(originalText);

                        let itemDiv = $('.equipment-item[data-id="' + id + '"]');
                        if (itemDiv.length > 0) {
                            let currentQty = parseInt(itemDiv.find('.quantity-value').text());
                            let available = parseInt(itemDiv.data('available'));
                            let remainingStock = available - currentQty;

                            itemDiv.find('.increase').prop('disabled', remainingStock <= 0);
                            itemDiv.find('.decrease').prop('disabled', currentQty <= 1);
                            itemDiv.find('.remove').prop('disabled', false);
                        }
                    }
                });
            }

            $('.increase').on('click', function() {
                if ($(this).prop('disabled') || isProcessing) {
                    return;
                }
                let id = $(this).data('id');
                let itemDiv = $('.equipment-item[data-id="' + id + '"]');
                let currentQty = parseInt(itemDiv.find('.quantity-value').text());
                let available = parseInt(itemDiv.data('available'));
                updateCart(id, 'increase');
            });

            $('.decrease').on('click', function() {
                if ($(this).prop('disabled') || isProcessing) {
                    return;
                }
                let id = $(this).data('id');
                let itemDiv = $('.equipment-item[data-id="' + id + '"]');
                let currentQty = parseInt(itemDiv.find('.quantity-value').text());
                updateCart(id, 'decrease');
            });
            $('.remove').on('click', function() {
                if ($(this).prop('disabled') || isProcessing) {
                    return;
                }
                let id = $(this).data('id');
                Swal.fire({
                    title: 'ยืนยันการลบ',
                    text: 'คุณแน่ใจหรือไม่ว่าต้องการลบอุปกรณ์นี้?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateCart(id, 'remove');
                    }
                });
            });
        });
    </script>
@endsection
