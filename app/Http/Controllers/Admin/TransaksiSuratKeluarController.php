<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSuratKeluar;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
            ->addColumn('action','admin.transaksi-surat-keluar.action')
            ->rawColumns(['action','tanggal_surat','tanggal_keluar','jenis_surat','submit'])
            ->tojson();
        }
        return view('admin.transaksi-surat-keluar.index');
    }

    public function create()
    {
        $jenis_surat = JenisSurat::orderBy('id','DESC')->get();
        return view('admin.transaksi-surat-keluar.tambah',[
            'jenis_surat' => $jenis_surat
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "jenis" => ["required"],
            "judul" => ["required"],
            "nomor_surat" => ["required","unique:surat_keluars,nomor_surat"],
            "penerima" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_keluar" => ["required"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal disimpan!')->withErrors($validator)->withInput();
        }
        $surat_keluar = SuratKeluar::create([
            'judul' => $request->judul,
            'nomor_surat' => $request->nomor_surat,
            'penerima' => $request->penerima,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_keluar' => $request->tanggal_keluar,
            'deskripsi' => $request->deskripsi,
            'jenis_surat_id' => $request->jenis,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.transaksi.surat-keluar.draft',$surat_keluar->id)->with('success','Data berhasil disimpan, berstatus draft');
    }

    public function edit($id)
    {
        $surat_keluar = SuratKeluar::findOrFail($id);
        $jenis_surat = JenisSurat::orderBy('id','DESC')->get();
        return view('admin.transaksi-surat-keluar.edit',[
            'surat_keluar' => $surat_keluar,
            'jenis_surat' => $jenis_surat
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "jenis" => ["required"],
            "judul" => ["required"],
            "nomor_surat" => ["required","unique:surat_keluars,nomor_surat,".$id.",id"],
            "penerima" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_keluar" => ["required"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal diupdate!')->withErrors($validator)->withInput();
        }
        SuratKeluar::findOrFail($id)->update([
            'judul' => $request->judul,
            'nomor_surat' => $request->nomor_surat,
            'penerima' => $request->penerima,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_keluar' => $request->tanggal_keluar,
            'deskripsi' => $request->deskripsi,
            'jenis_surat_id' => $request->jenis,
        ]);
        return redirect()->route('admin.transaksi.surat-keluar.draft',$id)->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar')->findOrFail($id);
        if(count($surat_keluar->file_surat_keluar) > 0){
            foreach ($surat_keluar->file_surat_keluar as $value) {
                if (File::exists(public_path('storage/arsip/surat-keluar/'.$value->hash_file))) {
                    unlink(public_path('storage/arsip/surat-keluar/'.$value->hash_file));
                    FileSuratKeluar::where('id',$value->id)->delete();
                }else{
                    return back()->with('error','Terdapat kesalahan saat menghapus data, silahkan coba kembali!');exit;
                }
            }
        }
        $surat_keluar->delete();
        return back()->with('success','Surat keluar berhasil dihapus');
    }

    public function draft($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','jenis_surat')->findOrFail($id);
        return view('admin.transaksi-surat-keluar.draft',[
            'surat_keluar' => $surat_keluar,
        ]);
    }

    public function detail($id)
    {
        $surat_keluar = SuratKeluar::with('file_surat_keluar','user.jabatan','jenis_surat')->findOrFail($id);
        return view('admin.transaksi-surat-keluar.detail',[
            'surat_keluar' => $surat_keluar,
        ]);
    }

    public function store_lampiran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "file_lampiran" => ["required","file","mimes:png,jpeg,jpg,doc,docx,xls,xlsx,csv,ppt,pptx,pdf","max:4096"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','File lampiran gagal diupload!')->withErrors($validator)->withInput();
        }

        $file_surat = $request->file('file_lampiran');
        $hash_file = date('dmY-',time()).$id.'-'.substr($file_surat->hashName(),-30);
        if (!FileSuratKeluar::where('hash_file',$hash_file)->first()) {
            $file_surat->storeAs('public/arsip/surat-keluar',$hash_file);
            FileSuratKeluar::create([
                'surat_keluar_id' => $id,
                'nama_file' => $file_surat->getClientOriginalName(),
                'hash_file' => $hash_file,
                'mime_type' => $file_surat->getClientMimeType(),
                'extensi' => $file_surat->getClientOriginalExtension(),
                'ukuran_file' => $file_surat->getSize(),
            ]);
            return back()->with('success','File lampiran berhasil diupload');
        }else{
            return back()->with('error','File lampiran gagal diupload, harap upload kembali!');
        }
    }

    public function destroy_lampiran($id)
    {
        $file_surat_keluar = FileSuratKeluar::findOrFail($id);
        if($file_surat_keluar->count() > 0){
            if (File::exists(public_path('storage/arsip/surat-keluar/'.$file_surat_keluar->hash_file))) {
                //File::delete($image_path);
                unlink(public_path('storage/arsip/surat-keluar/'.$file_surat_keluar->hash_file));
                $file_surat_keluar->delete();
                return back()->with('success','File lampiran berhasil dihapus');
            }else{
                return back()->with('error','File lampiran not exists!');
            }
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }

    public function download_lampiran($id)
    {
        $file_surat_keluar = FileSuratKeluar::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-keluar/".$file_surat_keluar->hash_file);
        return response()->download($filePath, $file_surat_keluar->nama_file);
    }

    public function submit($id)
    {
        if(FileSuratKeluar::whereSuratKeluarId($id)->count() > 0){
            $surat_keluar = SuratKeluar::findOrFail($id);
            $surat_keluar->is_submit = true;
            $surat_keluar->update();
            return redirect()->route('admin.transaksi.surat-keluar.index')->with('success','Surat keluar berhasil disubmit');
        }else{
            return back()->with('error','Harap mengupload file lampiran terlebih dahulu!');
        }
    }
}
