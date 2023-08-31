@extends('layouts.admin', ['title' => 'Transaksi Surat Keluar','icon' => 'fas fa-mail-bulk'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <span>Form Edit</span>
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.transaksi.surat-keluar.update',$surat_keluar->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="form-group">
                        <label>Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ @old('judul',$surat_keluar->judul) }}" placeholder="Isi judul..." autofocus>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>No. Surat <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ @old('nomor_surat',$surat_keluar->nomor_surat) }}" placeholder="Isi nomor surat...">
                        @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Penerima <span class="text-danger">*</span></label>
                        <input type="text" name="penerima" class="form-control @error('penerima') is-invalid @enderror" value="{{ @old('penerima',$surat_keluar->penerima) }}" placeholder="Isi penerima...">
                        @error('penerima')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" id="selectJenis">
                            <option value="">- pilih -</option>
                            @foreach ($jenis_surat as $val)
                            <option value="{{ $val->id }}" @if (@old('jenis',$surat_keluar->jenis_surat_id) == $val->id) selected @endif>{{ $val->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ @old('tanggal_surat',$surat_keluar->tanggal_surat) }}">
                        @error('tanggal_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Keluar <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ @old('tanggal_keluar',$surat_keluar->tanggal_keluar) }}">
                        @error('tanggal_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="5" rows="5" placeholder="Isi deskripsi...">{{ @old('deskripsi',$surat_keluar->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-edit mr-1"></i> Update
                    </button>
                    <a href="{{ route('admin.transaksi.surat-keluar.draft',$surat_keluar->id) }}" class="btn btn-sm btn-danger shadow-sm">
                        <i class="fas fa-undo mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-keluar.index') }}">List Data</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-keluar.draft',$surat_keluar->id) }}">Draft</a></li>
<li class="breadcrumb-item active">Edit</li>
@endpush

@push('js')
<script>
$(document).ready(() => {
    $('#selectJenis').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
});
</script>
@endpush
