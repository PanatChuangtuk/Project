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
                <li class="breadcrumb-item"><a href="{{ route('administrator.admin') }}">อาจารย์ที่ปรึกษา</a></li>
            </ol>

            {{-- เนื้อหาหลัก --}}
            <div class="card">
                <div class="card-body">
                    {{-- ส่วนบนของตาราง --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.adviser') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            {{-- ช่องค้นหา --}}
                            <x-search />

                            <div class="d-flex align-items-center ms-2">
                                {{-- ปุ่มเพิ่มข้อมูลผู้ดูแลระบบ --}}
                                <a href="{{ route('administrator.adviser.add') }}"
                                    class="btn btn-primary d-flex align-items-center"
                                    style="white-space: nowrap;">เพิ่มข้อมูล
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- ตารางรายการผู้ใช้ --}}
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
                                    <th class="text-center">ชื่อ</th>
                                    <th class="text-center">นามสกุล</th>
                                    <th class="text-center">สถานะเปิดใช้งาน</th>
                                    <th class="text-center">การจัดการ</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="userTableBody">
                                @foreach ($adviser as $item)
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

                                                {{ $item->first_name ?? null }}

                                            </div>
                                        </td>
                                        <td class="text-center"> {{ $item->last_name ?? null }}</td>
                                        <td class="text-center">
                                            <x-status-label :status="$item->status" />
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    {{-- ปุ่มแก้ไข --}}
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.adviser.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    {{-- ปุ่มลบ --}}
                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.adviser.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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

                        {{-- แสดงปุ่มแบ่งหน้า --}}
                        <div>
                            {!! $adviser->links() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- เตรียม URL สำหรับลบหลายรายการ --}}
    <script>
        const currentPath = window.location.pathname;
        const bulkDeleteUrl = currentPath.endsWith('/') ? currentPath + 'bulk-delete' : currentPath + '/bulk-delete';
    </script>
@endsection

@section('script')
    {{-- โหลด jQuery, SweetAlert2 และสคริปต์ลบ --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/delete.js') }}"></script>
@endsection
