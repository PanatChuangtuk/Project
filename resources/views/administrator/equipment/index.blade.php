@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                        <form action="{{ route('administrator.equipment') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />
                            <div class="d-flex align-items-center ms-2 gap-2 flex-wrap">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#filterModal">
                                    ตัวกรองเพิ่มเติม
                                </button>
                                <a href="{{ route('administrator.equipment.add') }}"
                                    class="btn btn-primary d-flex align-items-center">
                                    เพิ่มข้อมูล
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <form action="{{ route('administrator.equipment') }}" method="GET" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">กรองข้อมูล</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="ปิด"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        {{-- สถานะ --}}
                                        <div class="col-md-12 mb-3">
                                            <label class="fw-bold d-block">สถานะ</label>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="status[]" value="1"
                                                    class="form-check-input"
                                                    {{ in_array('1', request()->input('status', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">เปิดใช้งาน</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="status[]" value="0"
                                                    class="form-check-input"
                                                    {{ in_array('0', request()->input('status', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">ปิดใช้งาน</label>
                                            </div>
                                        </div>

                                        {{-- หมวดหมู่ --}}
                                        <div class="mb-3">
                                            <label class="fw-bold d-block mb-2">หมวดหมู่</label>
                                            <div class="row"
                                                style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; border-radius: 6px; padding: 10px;">
                                                @foreach ($allCategories as $id => $name)
                                                    <div class="col-md-4">
                                                        <div class="form-check mb-2">
                                                            <input type="checkbox" name="category[]"
                                                                value="{{ $id }}" class="form-check-input"
                                                                id="category_{{ $id }}"
                                                                {{ in_array($id, request()->input('category', [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="category_{{ $id }}">{{ $name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">ใช้ตัวกรอง</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                    <th class="text-center">รูปคิวอาร์โค้ด</th>
                                    <th class="text-center">ชื่อหมวดหมู่</th>
                                    <th class="text-center">เลขอุปกรณ์</th>
                                    <th class="text-center">สถานะเปิดใช้งาน</th>
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
                                                @if ($item->image)
                                                    <img src="{{ asset('upload/file/qr_code/' . $item->image) }}"
                                                        class="rounded-circle"
                                                        style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#imageModal{{ $item->id }}" />
                                                @endif
                                            </div>
                                        </td>
                                        @if ($item->image)
                                            <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="imageModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg">
                                                        <div class="modal-body p-0">
                                                            <img src="{{ asset('upload/file/qr_code/' . $item->image) }}"
                                                                class="img-fluid w-100 rounded" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    {{ $item->item->name ?? null }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    {{ $item->number ?? null }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <x-status-label :status="$item->status" />
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0"
                                                        href="{{ route('administrator.equipment.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.equipment.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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

                        {{-- Pagination --}}
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
