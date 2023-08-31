@extends('layouts.admin', ['title' => 'Transaksi Surat Masuk','icon' => 'fas fa-mail-bulk'])

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <span>Form Edit</span>
        </h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.transaksi.surat-masuk.update',$surat_masuk->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="form-group">
                        <label>Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ @old('judul',$surat_masuk->judul) }}" placeholder="Isi judul..." autofocus>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>No. Surat <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ @old('nomor_surat',$surat_masuk->nomor_surat) }}" placeholder="Isi nomor surat...">
                        @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="pengirim" class="form-control @error('pengirim') is-invalid @enderror" value="{{ @old('pengirim',$surat_masuk->pengirim) }}" placeholder="Isi pengirim...">
                        @error('pengirim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" id="selectJenis">
                            <option value="">- pilih -</option>
                            @foreach ($jenis_surat as $val)
                            <option value="{{ $val->id }}" @if (@old('jenis',$surat_masuk->jenis_surat_id) == $val->id) selected @endif>{{ $val->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ @old('tanggal_surat',$surat_masuk->tanggal_surat) }}">
                        @error('tanggal_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Tanggal Diterima <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_diterima" class="form-control @error('tanggal_diterima') is-invalid @enderror" value="{{ @old('tanggal_diterima',$surat_masuk->tanggal_diterima) }}">
                        @error('tanggal_diterima')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="5" rows="5" placeholder="Isi deskripsi...">{{ @old('deskripsi',$surat_masuk->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-edit mr-1"></i> Update
                    </button>
                    <a href="{{ route('admin.transaksi.surat-masuk.draft',$surat_masuk->id) }}" class="btn btn-sm btn-danger shadow-sm">
                        <i class="fas fa-undo mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-masuk.index') }}">List Data</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.transaksi.surat-masuk.draft',$surat_masuk->id) }}">Draft</a></li>
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
