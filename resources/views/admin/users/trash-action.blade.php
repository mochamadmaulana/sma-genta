<div class="btn-group dropleft">
    <button type="button" class="btn btn-xs btn-secondary dropdown-toggle"
        data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('admin.users.restore', $model->id) }}" class="dropdown-item"><i class="fas fa-recycle"></i> Pulihkan</a>
        <form action="{{ route('admin.users.destroy-permanent', $model->id) }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="dropdown-item" onclick="return confirm('Yakin, untuk menghapus permanen {{ $model->nama_lengkap }} ?')"><i class="fas fa-ban"></i> Hapus Permanen</button>
        </form>
    </div>
</div>
