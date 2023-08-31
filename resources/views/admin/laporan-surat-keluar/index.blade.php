@extends('layouts.admin', ['title' => 'Laporan Surat Masuk','icon' => 'fas fa-book'])

@section('content')
<div class="container mb-4">
    <form action="{{ route('admin.laporan.surat-masuk.index') }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Dari (Tanggal Diterima) <sup class="text-danger">*</sup></label>
                    <input type="date" name="dari_tanggal" class="form-control @error('dari_tanggal') is-invalid @enderror" value="{{ request('dari_tanggal') }}">
                    @error('dari_tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Sampai (Tanggal Diterima) <sup class="text-danger">*</sup></label>
                    <input type="date" name="sampai_tanggal" class="form-control @error('sampai_tanggal') is-invalid @enderror" value="{{ request('sampai_tanggal') }}">
                    @error('sampai_tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search mr-1"></i> Search</button>
        <a href="{{ route('admin.laporan.surat-masuk.index') }}" class="btn btn-secondary btn-block"><i class="fas fa-sync-alt mr-1"></i> Refresh</a>
    </form>
</div>
@if($surat_masuk)
<div class="card mt-3">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md">
                <h5>Hasil pencarian :</h5>
                <span class="font-italic">Dari Tanggal : <b>{{ \Carbon\Carbon::parse(request('dari_tanggal'))->translatedFormat('d F Y') }}</b></span><br>
                <span class="font-italic">Sampai Tanggal : <b>{{ \Carbon\Carbon::parse(request('sampai_tanggal'))->translatedFormat('d F Y') }}</b></span><br>
                <span class="font-italic">Total Data : <b>{{ $surat_masuk->count() }}</b></span>
            </div>
        </div>
        <table id="tableShowSearch" class="table table-bordered table-hover">
            <thead class="bg-secondary">
                <tr>
                    <th>Judul</th>
                    <th>No. Surat</th>
                    <th>Pengirim</th>
                    <th>Jenis</th>
                    <th>Tanggal Surat</th>
                    <th>Tanggal Diterima</th>
                    <th width="5%" class="text-center"><i class="fas fa-cog"></i></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($surat_masuk as $item)
            <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->nomor_surat }}</td>
                <td>{{ $item->pengirim }}</td>
                <td><span class="badge badge-info">{{ $item->jenis_surat->nama_jenis }}</span></td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}</td>
                <td><span class="text-success">{{ \Carbon\Carbon::parse($item->tanggal_diterima)->translatedFormat('d F Y') }}</span></td>
                <td class="text-center">
                    <a href="{{ route('admin.arsip.surat-masuk.detail',$item->id) }}" class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

@push('breadcrumb')
<li class="breadcrumb-item active">Buat Laporan</li>
@endpush

@push('js')
<script>
    $(function () {
      $('#tableShowSearch').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
@endpush
