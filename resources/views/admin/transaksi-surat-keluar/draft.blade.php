@extends('layouts.admin', ['title' => 'Transaksi Surat Keluar','icon' => 'fas fa-mail-bulk'])

@section('content')
@if (count($surat_keluar->file_surat_keluar) < 1)
<div class="alert alert-warning fade show" role="alert">
    <i class="fas fa-exclamation mr-2"></i> Wajib mengupload file lampiran agar bisa disubmit.
</div>
@endif

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
                <div class="row mb-3">
                    <div class="col-lg">
                        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#uploadLampiranModal"><i class="fas fa-upload mr-1"></i> Upload Lampiran</button>

                        @if (count($surat_keluar->file_surat_keluar) > 0)
                        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#submitModal"><i class="fas fa-check-double mr-1"></i> Submit</button>
                        @endif
                    </div>
                </div>
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
                            @if (count($surat_keluar->file_surat_keluar) > 0)
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
                                        <a href="{{ route('admin.transaksi.surat-keluar.lampiran.download',$file_surat_keluar->id) }}" target="_blank" class="btn btn-xs btn-warning m-1" ><i class="fas fa-download"></i></a>
                                        <form action="{{ route('admin.transaksi.surat-keluar.lampiran.destroy', $file_surat_keluar->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-xs btn-danger shadow-sm" onclick="return confirm('Yakin, untuk menghapus file lampiran {{ $file_surat_keluar->nama_file }} ?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="font-italic text-center text-muted">No Data...</td>
                            </tr>
                            @endif
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
                    Detail Surat Keluar <small class="badge badge-secondary ml-1">Draft</small>
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

                <div class="mt-2">
                    <a href="{{ route('admin.transaksi.surat-keluar.edit',$surat_keluar->id) }}" class="btn btn-sm btn-success m-1"><i class="fas fa-pencil-alt mr-1"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-keluar.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Draft</li>
@endpush

@push('modal')
<!-- Modal Upload Lampiran -->
<div class="modal fade" id="uploadLampiranModal" tabindex="-1" aria-labelledby="uploadLampiranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadLampiranModalLabel">Upload Lampiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.transaksi.surat-keluar.lampiran.store',$surat_keluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>File Lampiran <span class="text-danger">* </span><br>
                            <small class="text-danger font-italic"> jpg, jpeg, png, pdf, docx, doc, xls, xlsx, csv, ppt, pptx (max 4096Kb)</small>
                        </label>
                        <div class="custom-file">
                            <input type="file" name="file_lampiran" class="custom-file-input @error('file_lampiran') is-invalid @enderror" id="customFile">
                            <label class="custom-file-label label-upload-file-lampiran" for="customFile">Choose file</label>
                            @error('file_lampiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Submit -->
<div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitModalLabel">Yakin, untuk submit surat keluar ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.transaksi.surat-keluar.submit',$surat_keluar->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Surat keluar yang telah disubmit tidak dapat diedit kembali, pastikan data surat dan lampiran sudah benar ya..</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-check-double mr-1"></i> Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('js')
<script>
$(function () {
    $('input[name="file_lampiran"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-upload-file-lampiran').html(fileName);
    });
})
</script>
@endpush
