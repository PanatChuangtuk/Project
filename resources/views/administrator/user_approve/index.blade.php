@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <style>
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
            height: 160px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 3px solid #fff;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }



        .avatar-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .swal2-container {
            z-index: 999990 !important;
        }

        /* ให้ Modal มี z-index ต่ำกว่า SweetAlert */
        .modal {
            z-index: 999980 !important;
        }

        /* เพิ่มสไตล์ให้กับปุ่ม */
        #editLink {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 30px;
            background-color: #17a2b8;
            /* สีของปุ่ม */
            color: white;
            transition: background-color 0.3s, transform 0.3s ease;
            /* เพิ่มการเปลี่ยนแปลงเมื่อ hover */
            text-decoration: none;
            cursor: pointer;
        }

        #editLink i {
            margin-right: 8px;
            /* เว้นช่องระหว่างไอคอนกับข้อความ */
        }

        /* เปลี่ยนสีเมื่อเลื่อนเมาส์ (hover) */
        #editLink:hover {
            background-color: #138496;
            /* สีเข้มเมื่อ hover */
            transform: scale(1.05);
            /* ขยายขนาดเล็กน้อยเมื่อ hover */
        }

        /* เพิ่มเงาให้ปุ่ม */
        #editLink:active {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #117a8b;
            /* สีเข้มขึ้นเมื่อคลิก */
        }

        /* เพิ่มการรองรับฟังก์ชันเมื่อปุ่มถูกเลือก */
        #editLink:focus {
            outline: none;
            /* ลบขอบของปุ่มที่ถูกเลือก */
            box-shadow: 0px 0px 5px rgba(38, 143, 255, 0.5);
        }

        .custom-modal-xl {
            max-width: 60%;
            /* หรือใส่เช่น 1200px */
        }
    </style>
@endsection

@section('content')
    <div id="overlay-loading"
        style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.7);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
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
                                        {{-- <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div> --}}
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
                                            {{-- <div class="form-check" style="font-size: 1rem;">
                                                <input type="checkbox" class="form-check-input check-item"
                                                    value="{{ $item->id }}">
                                            </div> --}}
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
                                                data-bs-target=".disapproveBtn" data-id="{{ $item->id }}"
                                                data-name-new="{{ $item->info->first_name ?? '' }} {{ $item->info->last_name ?? '' }}"
                                                data-email-new="{{ $item->email }}"
                                                data-adviser-new="{{ $item->info->adviser->first_name . ' ' . $item->info->adviser->last_name }}"
                                                data-student-new="{{ $item->info->student->student_number ?? null }}"
                                                data-avatar-new="{{ asset('upload/images/' . $item->info->avatar) }}"
                                                data-phone-new="{{ $item->info->mobile_phone ?? '' }}"
                                                data-name-old="{{ $item->info->student->first_name ?? '' }} {{ $item->info->student->last_name ?? '' }}"
                                                data-email-old="{{ $item->info->student->email ?? '' }}"
                                                data-phone-old="{{ $item->info->student->mobile_phone ?? '' }}"
                                                data-student-old="{{ $item->info->student->student_number ?? null }}"
                                                data-adviser-old="{{ $item->info->student->adviser->first_name . ' ' . $item->info->student->adviser->last_name }}">
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
        <div class="modal-dialog modal-dialog-centered custom-modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="twoColumnModalLabel">เปรียบเทียบข้อมูล</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-header new-data-header text-white">
                                    <i class="fas fa-star-of-life me-2"></i>ข้อมูลผู้สมัครใหม่
                                </div>
                                <div class="card-body">

                                    <div class="text-center mb-3">
                                        <div class="avatar-wrapper rounded-circle overflow-hidden mx-auto">
                                            <img src="" id="newAvatar" class="img-fluid" alt="Avatar"
                                                onclick="showFullScreen(this)"
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
                                    <div class="info-item mt-3">
                                        <div class="info-label"><i class="fas fa-id-card info-icon"></i>รหัสนักศึกษา:
                                        </div>
                                        <div class="info-value fw-bold" id="oldStudent">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item mt-1">
                                        <div class="info-label"><i class="fas fa-id-card info-icon"></i>อาจารย์ที่ปรึกษา:
                                        </div>
                                        <div class="info-value fw-bold" id="newAdviser">ไม่มีข้อมูล</div>
                                    </div>
                                    {{-- <div class="info-item mt-3">
                                        <div class="info-label"><i class="fas fa-id-card info-icon"></i>รหัสนักศึกษา:</div>
                                        <div class="info-value fw-bold" id="newStudent">ไม่มีข้อมูล</div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-header old-data-header text-white">
                                    <i class="fas fa-history me-2"></i>ข้อมูลนักศึกษา
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div class="avatar-wrapper rounded-circle overflow-hidden mx-auto">
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
                                    <div class="info-item mt-3">
                                        <div class="info-label"><i class="fas fa-id-card info-icon"></i>รหัสนักศึกษา:
                                        </div>
                                        <div class="info-value fw-bold" id="oldStudent">ไม่มีข้อมูล</div>
                                    </div>
                                    <div class="info-item mt-1">
                                        <div class="info-label"><i class="fas fa-id-card info-icon"></i>อาจารย์ที่ปรึกษา:
                                        </div>
                                        <div class="info-value fw-bold" id="oldAdviser">ไม่มีข้อมูล</div>
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

                        <a id="editLink" class="btn btn-info disapproveBtn">
                            <i class="bx bx-edit bx"></i> แก้ไข
                        </a>


                    </div>
                    <button type="button" class="btn btn-close-modal text-white" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <div id="fullscreenModal" onclick="hideFullScreen()" style="display: none;">
        <img id="fullscreenImage" src="" alt="Full Image">
    </div>
@endsection

@section('script')
    <script>
        $('#overlay-loading').fadeIn();
        const button = $(this);
        setTimeout(() => {
            $('#overlay-loading').fadeOut();
        }, 900);
        $(document).ready(function() {
            let currentUserId;

            $('.show-modal-btn').on('click', function() {

                currentUserId = $(this).data('id');
                const newName = $(this).data('name-new');
                const newEmail = $(this).data('email-new');
                const newPhone = $(this).data('phone-new');
                // const newStudent = $(this).data('student-new');
                const newAvatar = $(this).data('avatar-new');
                const oldName = $(this).data('name-old');
                const oldEmail = $(this).data('email-old');
                const oldPhone = $(this).data('phone-old');
                const oldAvatar = $(this).data('avatar-old');
                const oldStudent = $(this).data('student-old');
                const oldAdviser = $(this).data('adviser-old');
                const newAdviser = $(this).data('adviser-new');
                $('#newName').text(newName || 'ไม่มีข้อมูล');
                // $('#newStudent').text(newStudent || 'ไม่มีข้อมูล');
                $('#newEmail').text(newEmail || 'ไม่มีข้อมูล');
                $('#newPhone').text(newPhone || 'ไม่มีข้อมูล');
                $('#oldName').text(oldName || 'ไม่มีข้อมูล');
                $('#oldEmail').text(oldEmail || 'ไม่มีข้อมูล');
                $('#oldPhone').text(oldPhone || 'ไม่มีข้อมูล');
                $('#oldStudent').text(oldStudent || 'ไม่มีข้อมูล');
                $('#oldAdviser').text(oldAdviser || 'ไม่มีข้อมูล');
                $('#newAdviser').text(newAdviser || 'ไม่มีข้อมูล');
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
                        url: `/administrator/approve-user/approve`,
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
            $('.disapproveBtn').on('click', function() {
                const editUrl = "{{ route('administrator.user.edit', ['id' => ':id']) }}".replace(':id',
                    currentUserId);
                $('#editLink').attr('href', editUrl);
                window.location.href = editUrl;
            });
        });
    </script>
    <script>
        function showFullScreen(img) {
            const fullScreenImg = document.createElement('img');
            fullScreenImg.src = img.src;
            fullScreenImg.style.maxWidth = '100%';
            fullScreenImg.style.maxHeight = '100%';
            fullScreenImg.style.objectFit = 'contain';
            fullScreenImg.style.zIndex = '1000001';

            const fullScreenContainer = document.createElement('div');
            fullScreenContainer.style.position = 'fixed';
            fullScreenContainer.style.top = '0';
            fullScreenContainer.style.left = '0';
            fullScreenContainer.style.width = '100vw';
            fullScreenContainer.style.height = '100vh';
            fullScreenContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.95)';
            fullScreenContainer.style.display = 'flex';
            fullScreenContainer.style.alignItems = 'center';
            fullScreenContainer.style.justifyContent = 'center';
            fullScreenContainer.style.zIndex = '1000000';

            const closeButton = document.createElement('div');
            closeButton.innerHTML = '&times;';
            closeButton.style.position = 'absolute';
            closeButton.style.top = '20px';
            closeButton.style.right = '30px';
            closeButton.style.fontSize = '40px';
            closeButton.style.color = '#fff';
            closeButton.style.cursor = 'pointer';
            closeButton.style.zIndex = '1000002';

            closeButton.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });

            fullScreenContainer.addEventListener('click', function(e) {
                if (e.target === fullScreenContainer) {
                    document.body.removeChild(fullScreenContainer);
                }
            });

            fullScreenContainer.appendChild(closeButton);
            fullScreenContainer.appendChild(fullScreenImg);
            document.body.appendChild(fullScreenContainer);
        }
    </script>
@endsection
