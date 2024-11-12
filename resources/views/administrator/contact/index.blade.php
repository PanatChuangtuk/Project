@extends('administrator.layouts.main')

@section('title')
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-bread-crumb  />

            {{-- Content --}}
            <div class="card">
                <div class="card-body">

                    {{-- Table --}}
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Fax</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th class="text-center">Create Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="contactTableBody">
                                @foreach ($contact as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('upload/file/banner/' . $item->image) }}" alt="{{ $item->image }}" class="img-thumbnail w-px-50 h-px-50" />
                                            @else
                                                <img src="https://via.placeholder.com/50" alt="Placeholder Image" class="img-thumbnail w-px-50 h-px-50" />
                                            @endif
                                        </td> 
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->phone }}</td>
                                        <td class="text-center">{{ $item->fax }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->content->address ?? 'No address' }}</td>
                                        <td class="text-center">{{ $item->created_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-inline-block text-nowrap">
                                                    <a class="btn btn-icon btn-outline-primary border-0" href="{{ route('administrator.contact.edit',['id' => $item->id]) }}">
                                                        <i class="bx bx-edit bx"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div>
                            {!! $contact->links() !!}
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
