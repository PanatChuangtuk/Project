@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.student') }}">นักศึกษา</a></li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    {{-- ส่วนหัว --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.student') }}" method="GET" class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- ค้นหา -->
                                <x-search />

                                <div class="d-flex align-items-center">
                                    <!-- ปุ่มเปิด Modal -->
                                    <button type="button" class="btn btn-outline-primary btn-lg me-2"
                                        data-bs-toggle="modal" data-bs-target="#registerModal">
                                        เพิ่มนักศึกษา
                                    </button>

                                    <!-- ปุ่มเพิ่มผู้ใช้งาน -->
                                    <a href="{{ route('administrator.student.add') }}" class="btn btn-primary btn-lg me-2"
                                        style="white-space: nowrap;">
                                        เพิ่มข้อมูล
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="registerModalLabel">ข้อมูลนักศึกษา</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="ปิด"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('administrator.student.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">เลือกไฟล์ Excel เพื่ออัปโหลด</label>
                                            <input type="file" name="file" id="file" class="form-control"
                                                accept=".xlsx, .xls, .csv">
                                            <i class="fas fa-exclamation-circle"> <span
                                                    class="text-danger">กรุณาใช้รูปแบบไฟล์ที่กำหนดเท่านั้น</span></i>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class='bx bx-upload'></i> นำเข้าข้อมูล
                                            </button>
                                        </div>
                                    </form>

                                    <a href="{{ asset('upload/ตัวอย่างที่ใช่ในการImport.csv') }}"
                                        class="btn btn-outline-primary mt-3" download><i class='bx bx-download'></i>
                                        ดาวน์โหลดรูปแบบไฟล์นำเข้า</a>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ตารางข้อมูล --}}
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="font-size: 1rem;">
                                        <div class="form-check">
                                            <input class="form-check-input check-item" type="checkbox" id="checkAll" />
                                        </div>
                                    </th>
                                    <th>ลำดับ</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">รหัสนักศึกษา</th>
                                    <th class="text-center">อีเมล</th>
                                    <th class="text-center">เบอร์โทรศัพท์</th>
                                    <th class="text-center">การจัดการ</th>
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
                                                {{ $item->first_name . ' ' . $item->last_name }}
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->student_number }}</td>
                                        <td class="text-center">{{ $item->email }}</td>
                                        <td class="text-center">{{ $item->mobile_phone ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.student.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.student.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-icon btn-outline-danger border-0 btn-delete"
                                                            data-id="{{ $item->id }}">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- การแบ่งหน้า --}}
                        <div>
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const currentPath = window.location.pathname;
        const bulkDeleteUrl = currentPath.endsWith('/') ? currentPath + 'bulk-delete' : currentPath + '/bulk-delete';
    </script>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/delete.js') }}"></script>
@endsection
