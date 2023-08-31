@extends('layouts.admin', ['title' => 'Jenis Surat','icon' => 'fas fa-layer-group'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <span>Form Tambah</span>
        </h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('admin.jenis-surat.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Jenis <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" value="{{ @old('nama_jenis') }}" placeholder="Isi nama jenis..." autofocus>
                        @error('nama_jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-paper-plane mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.jenis-surat.index') }}" class="btn btn-sm btn-danger shadow-sm">
                        <i class="fas fa-undo mr-1"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.jenis-surat.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endpush
