@extends('layouts.admin', ['title' => 'Users', 'icon' => 'fas fa-users'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">
                    <span>List Data</span>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                    @if($sampah)
                    <div class="col-lg">
                        <a href="{{ route('admin.users.trash') }}" class="btn btn-sm btn-danger shadow-sm float-right"><i class="fas fa-trash"></i> Sampah</a>
                    </div>
                    @endif
                </div>
                <table id="tableUser" class="table table-bordered table-hover">
                    <thead class="bg-secondary">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th width="5%" class="text-center"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item active">List Data</li>
@endpush

@push('js')
<script>
$(function () {
    $('#tableUser').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': '{!! route('admin.users.index') !!}',
            'contentType': 'application/json'
        },
        ordering: false,
        order: [],
        responsive: true,
        info: false,
        columns: [
            {data: 'DT_RowIndex', searchable: false, className: 'text-center'},
            {data: 'nama_lengkap'},
            {data: 'username'},
            {data: 'jabatan.nama_jabatan'},
            {data: 'status'},
            {data: 'role'},
            {data: 'action', searchable: false},
        ]
    });
});
</script>
@endpush
