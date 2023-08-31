@extends('layouts.admin', ['title' => 'Template Surat','icon' => 'fas fa-file-alt'])
@section('content')
@if ($errors->has('file_template'))
<div class="alert alert-danger">
    @error('file_template')<i class=" fas fa-times mr-1"></i> {{ $message }}@enderror
</div>
@endif
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <span>Form Tambah</span>
        </h3>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="{{ route('admin.template-surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>File Template <span class="text-danger">*</span><br>
                            <sup class="text-danger font-italic">docx, doc, xls, xlsx, csv, ppt, pptx (max 2048KB)</sup>
                        </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file_template" class="custom-file-input @error('file_template') is-invalid @enderror" id="customFile">
                                <label class="custom-file-label label-file-template" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama File <span class="text-danger">*</span></label>
                        <input type="text" name="nama_file" class="form-control @error('nama_file') is-invalid @enderror" value="{{ @old('nama_file') }}" placeholder="Isi nama file..." autofocus>
                        @error('nama_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" id="selectJenis">
                            <option value="">- pilih -</option>
                            @foreach ($jenis_surat as $val)
                            <option value="{{ $val->id }}" @if (@old('jenis') == $val->id) selected @endif>{{ $val->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</span></div>@enderror
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
<li class="breadcrumb-item"><a href="{{ route('admin.template-surat.index') }}">List Data</a></li>
<li class="breadcrumb-item active">Tambah</li>
@endpush

@push('js')
<script>
$(document).ready(() => {
    $('input[name="file_template"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.label-file-template').html(fileName);
    });
    $('#selectJenis').select2({
        theme: 'bootstrap4',
        // placeholder: '-Pilih-'
    })
});
</script>
@endpush
