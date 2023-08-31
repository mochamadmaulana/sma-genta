@extends('layouts.kepala-sekolah', ['title' => 'Profile','icon' => 'fas fa-user'])

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
                        <form action="{{ route('kepala-sekolah.profile.update',Auth::user()->id) }}" method="POST">
                            @csrf
                            @method("put")
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ @old('nama_lengkap',Auth::user()->nama_lengkap) }}" placeholder="Isi nama lengkap...">
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username',Auth::user()->username) }}" placeholder="Isi username...">
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email',Auth::user()->email) }}" placeholder="Isi email...">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ @old('nip',Auth::user()->nip_pegawai) }}" placeholder="Isi nip pegawai...">
                                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5" placeholder="Isi alamat...">{{ @old('alamat',Auth::user()->alamat) }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit mr-1"></i> Update
                            </button>
                            <a href="{{ route('kepala-sekolah.profile.index') }}" class="btn btn-sm btn-danger shadow-sm">
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
<li class="breadcrumb-item"><a href="{{ route('kepala-sekolah.profile.index') }}">Profile</a></li>
<li class="breadcrumb-item active">Edit</li>
@endpush
