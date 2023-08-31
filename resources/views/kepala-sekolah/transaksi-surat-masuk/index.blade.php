@extends('layouts.kepala-sekolah', ['title' => 'Transaksi Surat Masuk','icon' => 'fas fa-mail-bulk'])

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
                <table id="tablesuratmasuk" class="table table-bordered table-hover">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>No. Surat</th>
                            <th>Pengirim</th>
                            <th>Jenis</th>
                            <th>Submit</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
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
            'url': '{!! route('kepala-sekolah.transaksi.surat-masuk.index') !!}',
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
            {data: 'pengirim'},
            {data: 'jenis_surat'},
            {data: 'submit'},
            {data: 'tanggal_surat'},
            {data: 'tanggal_diterima'},
            {data: 'action', searchable: false},
        ]
      });
    });
</script>
@endpush
