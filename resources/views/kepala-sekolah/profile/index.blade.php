@extends('layouts.kepala-sekolah', ['title' => 'Profile','icon' => 'fas fa-user'])

@section('content')
<div class="row">
    <div class="col-md">
        <div class="row">
            <div class="col-md">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Detail</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <strong><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                                <p class="text-muted">{{ Auth::user()->nama_lengkap }}</p>
                                <hr>

                                <strong><i class="fas fa-id-card-alt mr-1"></i> Username</strong>
                                <p class="text-muted">{{ Auth::user()->username }}</p>
                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                                <p class="text-muted">{{ Auth::user()->email }}</p>
                                <hr>

                                <strong><i class="fas fa-briefcase mr-1"></i> Jabatan</strong>
                                <p class="text-muted">{{ Auth::user()->jabatan->nama_jabatan }}</p>
                                <hr>
                            </div>

                            <div class="col-lg-6">
                                <strong><i class="fas fa-user-secret mr-1"></i> Role</strong>
                                <p class="text-muted">{{ Auth::user()->role }}</p>
                                <hr>

                                <strong><i class="fas fa-check mr-1"></i> Status</strong>
                                <p class="text-muted">
                                @if(Auth::user()->status == true)
                                <span class="badge badge-pill badge-success">Aktif</span>
                                @else
                                <span class="badge badge-pill badge-danger">Tidak Aktif</span>
                                @endif
                                </p>
                                <hr>

                                <strong><i class="fas fa-address-card mr-1"></i> KTP</strong>
                                    @if(!empty(Auth::user()->nik_ktp) && !empty(Auth::user()->photo_ktp))
                                        <p class="text-muted">
                                            <a href="{{ asset('storage/image/ktp/'.Auth::user()->photo_ktp) }}" class="mr-2" target="_blank">{{ Auth::user()->nik_ktp }}</a>
                                            <a href="javascript:void(0)" class="badge badge-success" data-toggle="modal" data-target="#ModalEditKtp"><i class="fas fa-pencil-alt"></i> Edit</a>
                                            <a href="{{ route('kepala-sekolah.profile.destroy_ktp') }}" class="badge badge-danger" onclick="return confirm('Yakin, untuk menghapus ktp ?')"><i class="fas fa-trash"></i> Hapus</a>
                                        </p>
                                    @else
                                        <p class="text-muted"><a href="javascript:void(0)" class="badge badge-warning" data-toggle="modal" data-target="#ModalUploadKtp"><i class="fas fa-upload mr-1"></i> Upload</a></p>
                                    @endif
                                <hr>

                                <strong><i class="fas fa-address-card mr-1"></i> NIP</strong>
                                <p class="text-muted">{{ Auth::user()->nip_pegawai ?? '...' }}</p>
                                <hr>
                            </div>
                        </div>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ Auth::user()->alamat ?? '...' }}</p>
                        <hr>

                        <a href="{{ route('kepala-sekolah.profile.edit') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-pencil-alt mr-1"></i> Edit</a>
                    </div>
                    <!-- /Profile -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <!-- Photo Profile -->
        <div class="card {{ empty(Auth::user()->photo_profile) ? 'card-warning' : 'card-danger' }} card-outline">
            <div class="card-header">
                <h3 class="card-title">Photo Profile</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body box-profile">
                <div class="text-center mb-4">
                    @if(!empty(Auth::user()->photo_profile))
                    <a href="{{ asset('storage/image/avatar/'.Auth::user()->photo_profile) }}" target="_blank">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/image/avatar/resize/'.Auth::user()->photo_profile) }}" alt="User profile picture">
                    </a>
                    @else
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/image/default.jpg') }}" alt="User profile picture">
                    @endif
                </div>

                @if(!empty(Auth::user()->photo_profile))
                <a class="btn btn-success btn-sm btn-block shadow-sm mb-1" href="javascript:void(0)" data-toggle="modal" data-target="#ModalEditPhoto"><i class="fas fa-edit mr-1"></i> Edit</a>
                <form action="{{ route('kepala-sekolah.profile.destroy_photo') }}" method="POST" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm btn-block shadow-sm" onclick="return confirm('Yakin, untuk menghapus photo profile ?')"><i class="fas fa-trash mr-1"></i> hapus</button>
                </form>
                @else
                <a class="btn btn-warning btn-sm btn-block shadow-sm" href="javascript:void(0)" data-toggle="modal" data-target="#ModalUploadPhoto"><i class="fas fa-upload mr-1"></i> Upload</a>
                @endif
            </div>
        </div>

        <!-- Password -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Password</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kepala-sekolah.profile.edit_password') }}">
                    @csrf
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span><br>
                            <sup class="text-danger font-italic"> Min 6 karakter</sup>
                        </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ @old('password') }}" placeholder="******">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="konfirmasi_password" class="form-control @error('konfirmasi_password') is-invalid @enderror" placeholder="******">
                        @error('konfirmasi_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-sm btn-block btn-primary shadow-sm"><i class="fas fa-lock mr-1"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
<!-- Modal Edit KTP -->
<div class="modal fade" id="ModalEditKtp" tabindex="-1" aria-labelledby="ModalEditKtpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditKtpLabel">Edit KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kepala-sekolah.profile.edit_ktp') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>NIK. KTP <span class="text-danger">*</span></label>
                        <input type="text" name="nik_ktp_edit" class="form-control @error('nik_ktp_edit') is-invalid @enderror" value="{{ @old('nik_ktp_edit',Auth::user()->nik_ktp) }}" placeholder="Isi nik ktp...">
                        @error('nik_ktp_edit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>File KTP <sup class="text-warning font-italic">Opsional</sup><br>
                            <sup class="text-danger font-italic">jpg, jpeg, png, pdf (max 2048Kb)</sup>
                        </label>
                        <div class="custom-file">
                            <input type="file" name="file_ktp_edit" class="custom-file-input @error('file_ktp_edit') is-invalid @enderror" id="customFile">
                            <label class="custom-file-label label-file-ktp-edit" for="customFile">Choose file</label>
                            @error('file_ktp_edit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-edit mr-1"></i> Update</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload KTP -->
<div class="modal fade" id="ModalUploadKtp" tabindex="-1" aria-labelledby="ModalUploadKtpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUploadKtpLabel">Upload KTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kepala-sekolah.profile.upload_ktp') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <label>NIK. KTP<span class="text-danger"> *</span></label>
                            <input type="text" name="nik_ktp" class="form-control @error('nik_ktp') is-invalid @enderror" value="{{ @old('nik_ktp') }}" placeholder="Isi nik ktp...">
                            @error('nik_ktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <label>File KTP <span class="text-danger">*</span><br>
                            <sup class="text-danger font-italic">jpg, jpeg, png, pdf (max 2048Kb)</sup>
                        </label>
                        <div class="custom-file">
                            <input type="file" name="file_ktp" class="custom-file-input @error('file_ktp') is-invalid @enderror" id="customFile">
                            <label class="custom-file-label label-file-ktp" for="customFile">Choose file</label>
                            @error('file_ktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Upload Photo -->
<div class="modal fade" id="ModalUploadPhoto" tabindex="-1" aria-labelledby="ModalUploadPhotoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUploadPhotoLabel">Upload Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kepala-sekolah.profile.upload_photo') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>File Photo <span class="text-danger">*</span><br>
                            <sup class="text-danger font-italic">jpg, jpeg, png (max 2048Kb)</sup>
                        </label>
                        <div class="custom-file">
                            <input type="file" name="file_photo" class="custom-file-input @error('file_photo') is-invalid @enderror" id="customFile">
                            <label class="custom-file-label label-photo-profile" for="customFile">Choose file</label>
                            @error('file_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Edit Photo -->
<div class="modal fade" id="ModalEditPhoto" tabindex="-1" aria-labelledby="ModalEditPhotoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditPhotoLabel">Edit Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kepala-sekolah.profile.edit_photo') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>File Photo <span class="text-danger">*</span><br>
                            <sup class="text-danger font-italic">jpg, jpeg, png (max 2048Kb)</sup>
                        </label>
                        <div class="custom-file">
                            <input type="file" name="file_photo_edit" class="custom-file-input @error('file_photo_edit') is-invalid @enderror" id="customFile">
                            <label class="custom-file-label label-photo-profile" for="customFile">Choose file</label>
                            @error('file_photo_edit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-paper-plane mr-1"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-secondary shadow-sm" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endpush

@push('breadcrumb')
<li class="breadcrumb-item active">Profile</li>
@endpush

@push('js')
<script>
$(document).ready(function (e) {
    $('input[name="file_ktp_edit"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-file-ktp-edit').html(fileName);
    });
    $('input[name="file_ktp"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-file-ktp').html(fileName);
    });
    $('input[name="file_photo"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-photo-profile').html(fileName);
    });
    $('input[name="file_photo_edit"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-photo-profile').html(fileName);
    });
});
</script>
@endpush
