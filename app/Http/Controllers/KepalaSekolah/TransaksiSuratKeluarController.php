<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\FileSuratKeluar;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiSuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $surat_keluar = SuratKeluar::orderBy('id','DESC')->get();
            return DataTables::of($surat_keluar)
            ->addIndexColumn()
            ->removeColumn('id')
            ->editColumn('tanggal_surat',function($data){
                return Carbon::parse($data->tanggal_surat)->translatedFormat('d F Y');
            })
            ->editColumn('tanggal_keluar',function($data){
                return Carbon::parse($data->tanggal_keluar)->translatedFormat('d F Y');
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
            ->addColumn('action','kepala-sekolah.transaksi-surat-keluar.action')
            ->rawColumns(['action','tanggal_surat','tanggal_keluar','jenis_surat','submit'])
            ->tojson();
        }
        return view('kepala-sekolah.transaksi-surat-keluar.index');
    }

    public function detail($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','user.jabatan','jenis_surat')->findOrFail($id);
        return view('kepala-sekolah.transaksi-surat-keluar.detail',[
            'surat_keluar' => $surat_keluar,
        ]);
    }

    public function download_lampiran($id)
    {
        $file_surat_keluar = FileSuratKeluar::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-keluar/".$file_surat_keluar->hash_file);
        return response()->download($filePath, $file_surat_keluar->nama_file);
    }
}
