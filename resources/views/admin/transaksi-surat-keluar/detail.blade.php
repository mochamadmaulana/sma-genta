@extends('layouts.admin', ['title' => 'Transaksi Surat Keluar','icon' => 'fas fa-mail-bulk'])

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">File Lampiran</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Ukuran</th>
                                <th class="text-center"><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surat_keluar->file_surat_keluar as $key => $file_surat_keluar)
                            <tr>
                                <td>
                                    <?php $ext = ['pdf','jpg','jpeg','png']; ?>
                                    @if (in_array($file_surat_keluar->extensi,$ext))
                                    <a href="{{ asset('storage/arsip/surat-keluar/'.$file_surat_keluar->hash_file) }}" target="_blank">{{ $file_surat_keluar->nama_file }} <i class="fas fa-eye ml-1"></i></a>
                                    @else
                                    {{ $file_surat_keluar->nama_file }}
                                    @endif
                                </td>
                                <td>{{ number_format($file_surat_keluar->ukuran_file / 1024,'0',',','.') }}Kb</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.transaksi.surat-keluar.lampiran.download',$file_surat_keluar->id) }}" target="_blank" class="btn btn-xs btn-warning mr-1" ><i class="fas fa-download"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detail Surat Keluar <small class="badge badge-success ml-1">Submited</small>
                </h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </div>
            </div>

            <div class="card-body">
                <strong><i class="fas fa-envelope mr-1"></i> Judul </strong>
                <p class="text-muted">{{ $surat_keluar->judul }}</p>
                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> No. Surat </strong>
                <p class="text-muted">{{ $surat_keluar->nomor_surat }}</p>
                <hr>

                <strong><i class="fas fa-user mr-1"></i> Penerima</strong>
                <p class="text-muted">{{ $surat_keluar->penerima }}</p>
                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Jenis </strong>
                <p class="text-muted"><span class="badge badge-info">{{ $surat_keluar->jenis_surat->nama_jenis }}</span></p>
                <hr>

                <strong><i class="fas fa-calendar mr-1"></i> Tanggal Surat</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_keluar->tanggal_surat)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-calendar-check mr-1"></i> Tanggal Keluar</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($surat_keluar->tanggal_keluar)->translatedFormat('d F Y') }}</p>
                <hr>

                <strong><i class="fas fa-book-open mr-1"></i> Deskripsi</strong>
                <p class="text-muted">{{ $surat_keluar->deskripsi ?? '...' }}</p>
                <hr>

                <strong><i class="fas fa-user-check mr-1"></i> Diinput Oleh</strong>
                <p class="text-muted">{{ $surat_keluar->user->nama_lengkap }} <span class="badge badge-primary ml-1">{{ $surat_keluar->user->jabatan->nama_jabatan }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-keluar.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Detail</li>
@endpush
