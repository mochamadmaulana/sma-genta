@extends('layouts.admin', ['title' => 'Jenis Surat','icon' => 'fas fa-layer-group'])

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
                        <form action="{{ route('admin.jenis-surat.update', $jenis_surat->id) }}" method="POST">
                            @csrf
                            @method("patch")
                            <div class="form-group">
                                <label class="form-label">Nama Surat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror" value="{{ @old('nama_jenis',$jenis_surat->nama_jenis) }}" placeholder="Isi nama jenis-surat..." autofocus autocomplete="off" />
                                @error('nama_jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit mr-1"></i> Update
                            </button>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="btn btn-sm btn-danger shadow-sm">
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
<li class="breadcrumb-item"><a href="{{ route('admin.jenis-surat.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Edit</li>
@endpush
