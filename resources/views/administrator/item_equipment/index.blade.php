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
                <li class="breadcrumb-item"><a href="{{ route('administrator.category-equipment') }}">ประเภทอุปกรณ์</a></li>
            </ol>

            {{-- เนื้อหา --}}
            <div class="card">
                <div class="card-body">
                    {{-- หัว --}}
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <form action="{{ route('administrator.item-equipment') }}" method="GET"
                            class="d-flex justify-content-between align-items-center w-100">
                            <x-search />

                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-grow-1">
                                    <select class="form-select" id="itemFilter" name="category_id"
                                        onchange="this.form.submit()">
                                        <option value=""
                                            {{ request()->input('category_id') == '' ? 'selected' : '' }}>
                                            กรองตามหมวดหมู่
                                        </option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->input('category_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <a href="{{ route('administrator.item-equipment.add') }}"
                                    class="btn btn-primary d-flex align-items-center"
                                    style="white-space: nowrap;">เพิ่มข้อมูล
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- ตาราง --}}
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
                                    <th class="text-center">รูปอุปกรณ์</th>
                                    <th class="text-center">ชื่อหมวดหมู่อุปกรณ์</th>
                                    <th class="text-center">ชื่อประเภทอุปกรณ์</th>
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
                                                    <img src="{{ asset('upload/file/equipment_item/' . $item->image) }}"
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
                                                            <img src="{{ asset('upload/file/equipment_item/' . $item->image) }}"
                                                                class="img-fluid w-100 rounded" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    {{ $item->category->name ?? null }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="flex-grow-1">
                                                    {{ $item->name ?? null }}
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
                                                        href="{{ route('administrator.item-equipment.edit', ['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>

                                                    <form id="deleteForm{{ $item->id }}"
                                                        action="{{ route('administrator.item-equipment.destroy', ['id' => $item->id, 'page' => request()->get('page')]) }}"
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
