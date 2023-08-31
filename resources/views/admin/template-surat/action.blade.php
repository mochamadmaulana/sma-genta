<div class="btn-group dropleft">
    <button type="button" class="btn btn-xs btn-secondary dropdown-toggle"
        data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('admin.template-surat.download', $model->id) }}" class="dropdown-item"><i class="fas fa-download"></i> Download</a>
        <form action="{{ route('admin.template-surat.destroy', $model->id) }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="dropdown-item" onclick="return confirm('Yakin, untuk menghapus template surat ({{ $model->nama_file }}) ?')"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    </div>
</div>
