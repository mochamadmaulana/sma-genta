@extends('layouts.admin', ['title' => 'Users','icon' => 'fas fa-users'])

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
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="form-group text-center">
                                @if($user->photo_profile != null)
                                <img id="preview-photo-profile-before-upload" src="{{ asset('storage/image/avatar/resize/'.$user->photo_profile) }}" class="img-circle elevation-2 shadow" height="100px" width="100px" alt="Photo Profile">
                                @else
                                <img id="preview-photo-profile-before-upload" src="{{ asset('assets/image/default.jpg') }}" class="img-circle elevation-2 shadow" height="100px" width="100px" alt="Photo Profile">
                                @endif
                            </div>

                            @if($user->photo_profile)
                            <div class="text-center mb-3">
                                <a href="{{ route('admin.users.destroy-photo', $user->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin, untuk menghapus photo profile ?')"><i class="fas fa-trash mr-1"></i> Photo</a>
                            </div>
                            @endif

                            <div class="form-group">
                                <label>Photo Profile<br>
                                    <sup class="text-danger font-italic">jpg, jpeg, png, gif (max 2048KB)</sup>
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
                                <label>Nama Lengkap <span class="text-red">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ @old('nama_lengkap',$user->nama_lengkap) }}" placeholder="Isi nama lengkap..." autofocus>
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Username <span class="text-red">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username',$user->username) }}" placeholder="Isi username...">
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Password</label><br>
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPasswordModal"><i class="fas fa-lock mr-1"></i> Password</button>
                            </div>

                            <div class="form-group">
                                <label>Email <span class="text-red">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email',$user->email) }}" placeholder="email@example.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Jabatan <span class="text-red">*</span></label>
                                <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" id="selectJabatan">
                                    <option value="">- pilih -</option>
                                    @foreach ($jabatan as $val)
                                    <option value="{{ $val->id }}" @if (@old('jabatan',$user->jabatan_id) == $val->id) selected @endif>{{ $val->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Role <span class="text-red">*</span></label>
                                <select name="role" class="form-control @error('role') is-invalid @enderror" id="selectRole">
                                    <option value="">- pilih -</option>
                                    <option value="Admin" @if (@old('role',$user->role) == 'Admin') selected @endif>Admin</option>
                                    <option value="Kepala Sekolah" @if (@old('role',$user->role) == 'Kepala Sekolah') selected @endif>Kepala Sekolah</option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Status <span class="text-red">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="selectStatus">
                                    <option value="">- pilih -</option>
                                    <option value="aktif" @if (@old('status',$user->status) == 'aktif') selected @endif>Aktif</option>
                                    <option value="nonaktif" @if (@old('status',$user->status) == 'nonaktif') selected @endif>Nonaktif</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="5" placeholder="Isi alamat...">{{ @old('alamat',$user->alamat) }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-edit mr-1"></i> Update
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
<li class="breadcrumb-item active">Edit</li>
@endpush

@push('modal')
<!-- Modal Edit Password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.edit-password',$user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Password <sup class="text-red">* </sup><br>
                            <sup class="text-red font-italic"> Min 6 karakter</sup>
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ @old('password') }}" placeholder="******">
                        @error('password')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password <sup class="text-red">*</sup></label>
                        <input type="password" name="konfirmasi_password" class="form-control @error('konfirmasi_password') is-invalid @enderror" placeholder="******">
                        @error('konfirmasi_password')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('js')
<script>
$(document).ready(function (e) {
    $('input[name="photo_profile"]').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-photo-profile-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('input[name="photo_profile"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-photo-profile').html(fileName);
    });

    $('#selectJabatan').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
    $('#selectRole').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
    $('#selectStatus').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
});
</script>
@endpush
