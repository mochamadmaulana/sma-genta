@extends('layouts.admin', ['title' => 'Transaksi Surat Keluar','icon' => 'fas fa-mail-bulk'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <span>List Data</span>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg">
                        <a href="{{ route('admin.transaksi.surat-keluar.create') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <table id="tablesuratmasuk" class="table table-bordered table-hover">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>No. Surat</th>
                            <th>Penerima</th>
                            <th>Jenis</th>
                            <th>Submit</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Keluar</th>
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
  $('#tablesuratmasuk').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        'url': '{!! route('admin.transaksi.surat-keluar.index') !!}',
        'contentType': 'application/json'
    },
    ordering: false,
    order: [],
    responsive: true,
    info: false,
    columns: [
        {data: 'DT_RowIndex', searchable: false, className: 'text-center'},
        {data: 'judul'},
        {data: 'nomor_surat'},
        {data: 'penerima'},
        {data: 'jenis_surat'},
        {data: 'submit'},
        {data: 'tanggal_surat'},
        {data: 'tanggal_keluar'},
        {data: 'action', searchable: false},
    ]
  });
});
</script>
@endpush
