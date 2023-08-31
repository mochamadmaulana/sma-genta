@if($model->nama_jabatan != 'Kepala Sekolah' && $model->nama_jabatan != 'Staff TU' && $model->nama_jabatan != 'Kepala TU')
<div class="btn-group dropleft">
    <button type="button" class="btn btn-xs btn-secondary dropdown-toggle"
        data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('admin.jabatan.edit', $model->id) }}" class="dropdown-item"><i class="fas fa-edit"></i> edit</a>
        <form action="{{ route('admin.jabatan.destroy', $model->id) }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="dropdown-item" onclick="return confirm('Yakin, untuk menghapus jabatan {{ $model->nama_jabatan }} ?')"><i class="fas fa-trash"></i> hapus</button>
        </form>
    </div>
</div>
@endif
