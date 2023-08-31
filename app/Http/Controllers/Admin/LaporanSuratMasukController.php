<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanSuratMasukController extends Controller
{
    public function index()
    {
        return back()->with('error','Fitur masih tahap development!');die;
        $surat_masuk = 0;
        if(!empty(request('dari_tanggal')) && !empty(request('sampai_tanggal'))){
            $dari_tanggal = Carbon::parse(request('dari_tanggal'))->translatedFormat('Y-m-d');
            $sampai_tanggal = Carbon::parse(request('sampai_tanggal'))->translatedFormat('Y-m-d');
            $surat_masuk = SuratMasuk::with('file_surat_masuk','user.jabatan','jenis_surat')->latest()->whereBetween('tanggal_diterima',[$dari_tanggal,$sampai_tanggal])->where('is_submit',true)->get();
        }
        return view('admin.laporan-surat-masuk.index',[
            'surat_masuk' => $surat_masuk
        ]);
    }
}
