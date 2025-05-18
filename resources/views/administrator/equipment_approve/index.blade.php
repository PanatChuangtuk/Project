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
                <li class="breadcrumb-item"><a href="{{ route('administrator.approve-equipment') }}">อนุมัติการยืมอุปกรณ์</a>
                </li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    {{-- หัว --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.approve-equipment') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />

                        </form>
                    </div>

                    {{-- ตาราง --}}
                    <div class=" text-nowrap">
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
                                    <th class="text-center">ชนิดคำร้อง</th>
                                    <th class="text-center">สถานะคำร้อง</th>
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
                                                <div class="flex-grow-1">
                                                    {{ $item->member->info->first_name ?? null }}
                                                    {{ $item->member->info->last_name ?? null }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->member->info->student->student_number ?? null }}
                                        </td>
                                        <td class="text-center  align-middle">
                                            @if ($item->status_type == 'borrowed')
                                                <span class="badge bg-warning">ยืมอุปกรณ์</span>
                                            @elseif ($item->status_type == 'returned')
                                                <span class="badge bg-success">คืนอุปกรณ์</span>
                                            @elseif ($item->status_type == 'overdue')
                                                <span class="badge bg-danger">เกินกำหนด</span>
                                            @endif
                                        </td>
                                        <td class="text-center  align-middle">
                                            @if ($item->status == 'in_process')
                                                <span class="badge bg-warning">รอดำเนินการ</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.approve-equipment.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>
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
