<div class="btn-group dropleft">
    <button type="button" class="btn btn-xs btn-secondary dropdown-toggle"
        data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-cog"></i>
    </button>
    <div class="dropdown-menu">
        @if ($model->is_submit == false)
        <a href="{{ route('admin.transaksi.surat-keluar.draft', $model->id) }}" class="dropdown-item"><i class="fas fa-eye"></i> Draft</a>
        <form action="{{ route('admin.transaksi.surat-keluar.destroy', $model->id) }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="dropdown-item" onclick="return confirm('Yakin, untuk menghapus dengan no. surat {{ $model->nomor_surat }} ?')"><i class="fas fa-trash"></i> Hapus</button>
        </form>
        @else
        <a href="{{ route('admin.transaksi.surat-keluar.detail', $model->id) }}" class="dropdown-item"><i class="fas fa-eye"></i> Detail</a>
        @endif
    </div>
</div>
