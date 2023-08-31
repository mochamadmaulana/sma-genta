@extends('layouts.admin', ['title' => 'Jabatan','icon' => 'fas fa-briefcase'])
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
                <form action="{{ route('admin.jabatan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Jabatan <sup class="text-danger">*</sup></label>
                        <input type="text" name="nama_jabatan" class="form-control @error('nama_jabatan') is-invalid @enderror" value="{{ @old('nama_jabatan') }}" placeholder="Isi nama jabatan..." autofocus>
                        @error('nama_jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-paper-plane mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.jabatan.index') }}" class="btn btn-sm btn-danger shadow-sm">
                        <i class="fas fa-undo mr-1"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.jabatan.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endpush
