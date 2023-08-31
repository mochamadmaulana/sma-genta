<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSuratMasuk;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArsipSuratMasukController extends Controller
{
    public function index()
    {
        $surat_masuk = 0;
        if(!empty(request('dari_tanggal')) && !empty(request('sampai_tanggal'))){
            $dari_tanggal = Carbon::parse(request('dari_tanggal'))->translatedFormat('Y-m-d');
            $sampai_tanggal = Carbon::parse(request('sampai_tanggal'))->translatedFormat('Y-m-d');
            $surat_masuk = SuratMasuk::with('file_surat_masuk','user.jabatan','jenis_surat')->latest()->whereBetween('tanggal_diterima',[$dari_tanggal,$sampai_tanggal])->where('is_submit',true)->get();
        }
        return view('admin.arsip-surat-masuk.index',[
            'surat_masuk' => $surat_masuk
        ]);
    }

    public function detail($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','jenis_surat','user')->findOrFail($id);
        if($surat_masuk->count() > 0){
            return view('admin.arsip-surat-masuk.detail',[
                'surat_masuk' => $surat_masuk,
            ]);
        }else{
            return back()->with('error','Error, Data tidak ditemukan!');
        }
    }

    public function download_lampiran($id)
    {
        $file_surat_masuk = FileSuratMasuk::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-masuk/".$file_surat_masuk->hash_file);
        return response()->download($filePath, $file_surat_masuk->nama_file);
    }
}
