<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\FileSuratMasuk;
use App\Models\SuratMasuk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiSuratMasukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $surat_masuk = SuratMasuk::with('jenis_surat')->where('is_submit',true)->orderBy('id','DESC')->get();
            return DataTables::of($surat_masuk)
            ->addIndexColumn()
            ->removeColumn('id')
            ->editColumn('tanggal_surat',function($data){
                return Carbon::parse($data->tanggal_surat)->translatedFormat('d F Y');
            })
            ->editColumn('tanggal_diterima',function($data){
                return Carbon::parse($data->tanggal_diterima)->translatedFormat('d F Y');
            })
            ->editColumn('jenis_surat',function($data){
                return '<span class="badge badge-info">'.$data->jenis_surat->nama_jenis.'</span>';
            })
            ->editColumn('submit',function($data){
                if($data->is_submit){
                    return '<span class="badge badge-success">Submited</span>';
                }else{
                    return '<span class="badge badge-secondary">Draft</span>';
                }
            })
            ->addColumn('action','kepala-sekolah.transaksi-surat-masuk.action')
            ->rawColumns(['action','tanggal_surat','tanggal_diterima','jenis_surat','submit'])
            ->tojson();
        }
        return view('kepala-sekolah.transaksi-surat-masuk.index');
    }

    public function detail($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','user.jabatan','jenis_surat')->findOrFail($id);
        return view('kepala-sekolah.transaksi-surat-masuk.detail',[
            'surat_masuk' => $surat_masuk,
        ]);
    }

    public function download_lampiran($id)
    {
        $file_surat_masuk = FileSuratMasuk::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-masuk/".$file_surat_masuk->hash_file);
        return response()->download($filePath, $file_surat_masuk->nama_file);
    }
}
