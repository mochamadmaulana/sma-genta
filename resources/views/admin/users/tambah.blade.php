@extends('layouts.admin', ['title' => 'Users','icon' => 'fas fa-users'])

@section('content')

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <span>Form Tambah</span>
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-lg-6">

                            <div class="form-group text-center">
                                <img id="preview-photo-profile-before-upload" src="{{ asset('storage/image/avatar/default.jpg') }}" class="img-circle elevation-2 shadow" height="100px" width="100px" alt="Photo Profile">
                            </div>

                            <div class="form-group">
                                <label>Photo Profile<br>
                                    <sup class="text-danger font-italic">jpg, jpeg, png, gif (max 4096KB)</sup>
                                </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="photo_profile" class="custom-file-input @error('photo_profile') is-invalid @enderror" id="customFile">
                                        <label class="custom-file-label label-photo-profile" for="customFile">Choose file</label>
                                        @error('photo_profile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ @old('nama_lengkap') }}" placeholder="Isi nama lengkap..." autofocus>
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Username <span class="text-danger">* </span><br>
                                    <sup class="text-danger font-italic">Gunakan huruf kecil</sup>
                                </label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username') }}" placeholder="Isi username...">
                                @error('username')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email') }}" placeholder="email@example.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Password <span class="text-danger">* </span><br>
                                    <sup class="text-danger font-italic"> Min 6 karakter</sup>
                                </label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ @old('password') }}" placeholder="******">
                                @error('password')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" id="selectJabatan">
                                    <option value="">- pilih -</option>
                                    @foreach ($jabatan as $val)
                                    <option value="{{ $val->id }}" @if (@old('jabatan') == $val->id) selected @endif>{{ $val->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" id="selectRole">
                                    <option value="">- pilih -</option>
                                    <option value="Admin" @if (@old('role') == 'Admin') selected @endif>Admin</option>
                                    <option value="Kepala Sekolah" @if (@old('role') == 'Kepala Sekolah') selected @endif>Kepala Sekolah</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5" placeholder="Isi alamat...">{{ @old('alamat') }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-paper-plane mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-danger shadow-sm">
                                <i class="fas fa-undo mr-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endpush

@push('js')
<script>
$(document).ready(function (e) {
    $('input[name="photo_profile"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-photo-profile').html(fileName);
    });

    $('input[name="photo_profile"]').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-photo-profile-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#selectJabatan').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
    $('#selectRole').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
});
</script>
@endpush
