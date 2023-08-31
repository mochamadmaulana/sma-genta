@extends('layouts.admin', ['title' => 'Jabatan','icon' => 'fas fa-briefcase'])

@section('content')

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <span>Form Edit</span>
                </h3>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="{{ route('admin.jabatan.update', $jabatan->id) }}" method="POST">
                            @csrf
                            @method("patch")
                            <div class="form-group">
                                <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_jabatan" class="form-control @error('nama_jabatan') is-invalid @enderror" value="{{ @old('nama_jabatan',$jabatan->nama_jabatan) }}" placeholder="Isi nama jabatan..." autofocus autocomplete="off" />
                                @error('nama_jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit mr-1"></i> Update
                            </button>
                            <a href="{{ route('admin.jabatan.index') }}" class="btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-undo mr-1"></i> Batal
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.jabatan.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Edit</li>
@endpush
