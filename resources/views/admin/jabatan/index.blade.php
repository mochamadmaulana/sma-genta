@extends('layouts.admin', ['title' => 'Jabatan','icon' => 'fas fa-briefcase'])

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <span>List Data</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg">
                        <a href="{{ route('admin.jabatan.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <table id="tablejabatan" class="table table-bordered table-hover">
                    <thead class="bg-secondary">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama Jabatan</th>
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
    $('#tablejabatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': '{!! route('admin.jabatan.index') !!}',
            'contentType': 'application/json'
        },
        ordering: false,
        order: [],
        responsive: true,
        info: false,
        columns: [
            {data: 'DT_RowIndex', searchable: false, className: 'text-center'},
            {data: 'nama_jabatan'},
            {data: 'action', searchable: false},
        ]
    });
});
</script>
@endpush
