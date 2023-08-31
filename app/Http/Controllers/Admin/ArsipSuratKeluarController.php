<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSuratKeluar;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArsipSuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluar = 0;
        if(!empty(request('dari_tanggal')) && !empty(request('sampai_tanggal'))){
            $dari_tanggal = Carbon::parse(request('dari_tanggal'))->translatedFormat('Y-m-d');
            $sampai_tanggal = Carbon::parse(request('sampai_tanggal'))->translatedFormat('Y-m-d');
            $surat_keluar = SuratKeluar::with('file_surat_keluar','user.jabatan','jenis_surat')->latest()->whereBetween('tanggal_keluar',[$dari_tanggal,$sampai_tanggal])->where('is_submit',true)->get();
        }
        return view('admin.arsip-surat-keluar.index',[
            'surat_keluar' => $surat_keluar
        ]);
    }

    public function detail($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','jenis_surat','user')->findOrFail($id);
        if($surat_keluar->count() > 0){
            return view('admin.arsip-surat-keluar.detail',[
                'surat_keluar' => $surat_keluar,
            ]);
        }else{
            return back()->with('error','Error, Data tidak ditemukan!');
        }
    }

    public function download_lampiran($id)
    {
        $file_surat_keluar = FileSuratKeluar::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-keluar/".$file_surat_keluar->hash_file);
        return response()->download($filePath, $file_surat_keluar->nama_file);
    }
}
