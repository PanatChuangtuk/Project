@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Prompt', sans-serif;
        }

        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.5rem;
            background: transparent;
        }

        .btn-close {
            background-color: #f1f3f5;
            border-radius: 50%;
            padding: 0.75rem;
            opacity: 1;
        }

        .btn-close:hover {
            background-color: #e9ecef;
        }

        .modal-body {
            padding: 0.5rem 1.5rem 1.5rem;
        }

        .info-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
        }

        .new-data-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
        }

        .old-data-header {
            background: linear-gradient(135deg, #ff9a44 0%, #fc6076 100%);
            border: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            margin-bottom: 1rem;
            align-items: center;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 500;
            color: #6c757d;
            min-width: 100px;
        }

        .info-value {
            font-weight: 600;
            color: #343a40;
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            flex-grow: 1;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem 1.5rem;
            justify-content: center;
        }

        .btn-close-modal {
            border-radius: 50px;
            padding: 0.6rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .btn-close-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .info-icon {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            color: #6c757d;
        }

        /* For demo purposes */
        .demo-btn {
            margin: 2rem auto;
            display: block;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .avatar-wrapper {
            width: 160px;
            /* ปรับขนาดความกว้าง */
            height: 160px;
            /* ปรับขนาดความสูง */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 3px solid #fff;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            margin: 0 auto;
        }

        .avatar-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .swal2-container {
            z-index: 999999 !important;
        }

        /* ให้ Modal มี z-index ต่ำกว่า SweetAlert */
        .modal {
            z-index: 999998 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-bread-crumb />

            {{-- Content --}}
            <div class="card">
                <div class="card-body">
                    {{-- Head --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.approve-user') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="font-size: 1rem;">
                                        <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div>
                                    </th>
                                    <th>NO</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">STATUS</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="userTableBody">
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    <strong class="d-block">
                                                        {{ $item->info->first_name ?? null }} |
                                                        {{ $item->info->last_name ?? null }}
                                                    </strong>
                                                    <span class="text-muted small">
                                                        {{ $item->info->mobile_phone ?? null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->email }}</td>

                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-info mb-3 show-modal-btn" data-bs-toggle="modal"
                                                data-bs-target="#twoColumnModal" data-id="{{ $item->id }}"
                                                data-name-new="{{ $item->info->first_name ?? '' }} {{ $item->info->last_name ?? '' }}"
                                                data-email-new="{{ $item->email }}"
                                                data-avatar-new="{{ asset('upload/images/' . $item->info->avatar) }}"
                                                data-phone-new="{{ $item->info->mobile_phone ?? '' }}"
                                                data-name-old="{{ $item->info->student->first_name ?? '' }} {{ $item->info->student->last_name ?? '' }}"
                                                data-email-old="{{ $item->info->student->email ?? '' }}"
                                                data-phone-old="{{ $item->info->student->mobile_phone ?? '' }}">
                                                <i class='bx bx-user'></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="twoColumnModal" tabindex="-1" aria-labelledby="twoColumnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="twoColumnModalLabel">เปรียบเทียบข้อมูล</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- ข้อมูลใหม่ -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-header new-data-header text-white">
                                    <i class="fas fa-star-of-life me-2"></i>ข้อมูลผู้สมัครใหม่
                                </div>
                                <div class="card-body">
                                    <!-- เพิ่มส่วนแสดงรูปภาพ Avatar -->
                                    <div class="text-center mb-3">
                                        <div class="avatar-wrapper rounded-circle overflow-hidden mx-auto"
                                            style="width: 160px; height: 160px; object-fit: cover;">
                                            <img src="" id="newAvatar" class="img-fluid" alt="Avatar"
                                                onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=null;">
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-user info-icon"></i>ชื่อ:</div>
                                        <div class="info-value" id="newName">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-envelope info-icon"></i>อีเมล:</div>
                                        <div class="info-value" id="newEmail">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-phone-alt info-icon"></i>เบอร์โทร:</div>
                                        <div class="info-value" id="newPhone">ไม่มีข้อมูล</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ข้อมูลเก่า -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-header old-data-header text-white">
                                    <i class="fas fa-history me-2"></i>ข้อมูลนักศึกษา
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="avatar-wrapper rounded-circle overflow-hidden mx-auto"
                                            style="width: 160px; height: 160px; object-fit: cover;">
                                            <img src="" id="oldAvatar" class="img-fluid" alt="Avatar"
                                                onerror="this.src='{{ asset('images/default-avatar.png') }}'; this.onerror=null;">
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-user info-icon"></i>ชื่อ:</div>
                                        <div class="info-value" id="oldName">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-envelope info-icon"></i>อีเมล:</div>
                                        <div class="info-value" id="oldEmail">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label"><i class="fas fa-phone-alt info-icon"></i>เบอร์โทร:</div>
                                        <div class="info-value" id="oldPhone">ไม่มีข้อมูล</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <!-- ปุ่ม Approve -->
                    <div>
                        <button type="button" id="approveBtn" class="btn btn-success px-4 py-2">
                            <i class="fas fa-check-circle me-2"></i>อนุมัติ
                        </button>
                        {{-- <button type="button" id="disapproveBtn" class="btn btn-danger px-4 py-2">
                            <i class="fas fa-times-circle me-2"></i>ไม่อนุมัติ
                        </button> --}}
                    </div>
                    <button type="button" class="btn btn-close-modal text-white" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const currentPath = window.location.pathname;
        const bulkDeleteUrl = currentPath.endsWith('/') ? currentPath + 'bulk-delete' : currentPath + '/bulk-delete';
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/delete.js') }}"></script>
    <script>
        $(document).ready(function() {
            let currentUserId;

            $('.show-modal-btn').on('click', function() {
                currentUserId = $(this).data('id');
                const newName = $(this).data('name-new');
                const newEmail = $(this).data('email-new');
                const newPhone = $(this).data('phone-new');
                const newAvatar = $(this).data('avatar-new');
                const oldName = $(this).data('name-old');
                const oldEmail = $(this).data('email-old');
                const oldPhone = $(this).data('phone-old');
                const oldAvatar = $(this).data('avatar-old');

                $('#newName').text(newName || 'ไม่มีข้อมูล');
                $('#newEmail').text(newEmail || 'ไม่มีข้อมูล');
                $('#newPhone').text(newPhone || 'ไม่มีข้อมูล');
                $('#oldName').text(oldName || 'ไม่มีข้อมูล');
                $('#oldEmail').text(oldEmail || 'ไม่มีข้อมูล');
                $('#oldPhone').text(oldPhone || 'ไม่มีข้อมูล');

                // ตั้งค่ารูปภาพ
                if (newAvatar) {
                    $('#newAvatar').attr('src', newAvatar);
                } else {
                    $('#newAvatar').attr('src', '{{ asset('upload/404.jpg') }}');
                }

                if (oldAvatar) {
                    $('#oldAvatar').attr('src', oldAvatar);
                } else {
                    $('#oldAvatar').attr('src', '{{ asset('upload/404.jpg') }}');
                }
            });

            $('#approveBtn').on('click', function() {
                console.log(currentUserId);
                if (currentUserId) {
                    Swal.fire({
                        icon: 'info',
                        title: 'กำลังดำเนินการอนุมัติ...',
                        text: 'กรุณารอขณะกำลังดำเนินการ',
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let originalContent = $(this).html();
                    $(this).html(
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>กำลังอนุมัติ...'
                    );
                    $(this).attr('disabled', true);

                    $.ajax({
                        url: `/administrator/approve-user/approve `,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            query: currentUserId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'อนุมัติสำเร็จ',
                                text: 'ข้อมูลผู้ใช้ได้รับการอนุมัติเรียบร้อยแล้ว',
                                confirmButtonText: 'ตกลง'
                            }).then((result) => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถอนุมัติข้อมูลได้ โปรดลองอีกครั้ง',
                                confirmButtonText: 'ตกลง'
                            });
                            $('#approveBtn').html(originalContent);
                            $('#approveBtn').attr('disabled', false);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่พบข้อมูลผู้ใช้',
                        text: 'ไม่สามารถดำเนินการได้เนื่องจากไม่พบข้อมูลผู้ใช้',
                        confirmButtonText: 'ตกลง'
                    });

                }
            });
        });
    </script>
@endsection
