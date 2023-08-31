<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileSuratMasuk;
use App\Models\JenisSurat;
use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransaksiSuratMasukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $surat_masuk = SuratMasuk::with('jenis_surat')->orderBy('id','DESC')->get();
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
            ->addColumn('action','admin.transaksi-surat-masuk.action')
            ->rawColumns(['action','tanggal_surat','tanggal_diterima','jenis_surat','submit'])
            ->tojson();
        }
        return view('admin.transaksi-surat-masuk.index');
    }

    public function create()
    {
        $jenis_surat = JenisSurat::orderBy('id','DESC')->get();
        return view('admin.transaksi-surat-masuk.tambah',[
            'jenis_surat' => $jenis_surat
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "jenis" => ["required"],
            "judul" => ["required"],
            "nomor_surat" => ["required","unique:surat_masuks,nomor_surat"],
            "pengirim" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_diterima" => ["required"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal disimpan!')->withErrors($validator)->withInput();
        }
        $surat_masuk = SuratMasuk::create([
            'judul' => $request->judul,
            'nomor_surat' => $request->nomor_surat,
            'pengirim' => $request->pengirim,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'deskripsi' => $request->deskripsi,
            'jenis_surat_id' => $request->jenis,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('admin.transaksi.surat-masuk.draft',$surat_masuk->id)->with('success','Data berhasil disimpan, berstatus draft');
    }

    public function edit($id)
    {
        $surat_masuk = SuratMasuk::findOrFail($id);
        $jenis_surat = JenisSurat::orderBy('id','DESC')->get();
        return view('admin.transaksi-surat-masuk.edit',[
            'surat_masuk' => $surat_masuk,
            'jenis_surat' => $jenis_surat
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "jenis" => ["required"],
            "judul" => ["required"],
            "nomor_surat" => ["required","unique:surat_masuks,nomor_surat,".$id.",id"],
            "pengirim" => ["required"],
            "tanggal_surat" => ["required"],
            "tanggal_diterima" => ["required"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal diupdate!')->withErrors($validator)->withInput();
        }
        SuratMasuk::findOrFail($id)->update([
            'judul' => $request->judul,
            'nomor_surat' => $request->nomor_surat,
            'pengirim' => $request->pengirim,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_diterima' => $request->tanggal_diterima,
            'deskripsi' => $request->deskripsi,
            'jenis_surat_id' => $request->jenis,
        ]);
        return redirect()->route('admin.transaksi.surat-masuk.draft',$id)->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk')->findOrFail($id);
        if(count($surat_masuk->file_surat_masuk) > 0){
            foreach ($surat_masuk->file_surat_masuk as $value) {
                if (File::exists(public_path('storage/arsip/surat-masuk/'.$value->hash_file))) {
                    unlink(public_path('storage/arsip/surat-masuk/'.$value->hash_file));
                    FileSuratMasuk::where('id',$value->id)->delete();
                }else{
                    return back()->with('error','Terdapat kesalahan saat menghapus data, silahkan coba kembali!');exit;
                }
            }
        }
        $surat_masuk->delete();
        return back()->with('success','Surat masuk berhasil dihapus');
    }

    public function draft($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','jenis_surat')->findOrFail($id);
        return view('admin.transaksi-surat-masuk.draft',[
            'surat_masuk' => $surat_masuk,
        ]);
    }

    public function detail($id)
    {
        $surat_masuk = SuratMasuk::with('file_surat_masuk','user.jabatan','jenis_surat')->findOrFail($id);
        return view('admin.transaksi-surat-masuk.detail',[
            'surat_masuk' => $surat_masuk,
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
        if (!FileSuratMasuk::where('hash_file',$hash_file)->first()) {
            $file_surat->storeAs('public/arsip/surat-masuk',$hash_file);
            FileSuratMasuk::create([
                'surat_masuk_id' => $id,
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
        $file_surat_masuk = FileSuratMasuk::findOrFail($id);
        if($file_surat_masuk->count() > 0){
            if (File::exists(public_path('storage/arsip/surat-masuk/'.$file_surat_masuk->hash_file))) {
                //File::delete($image_path);
                unlink(public_path('storage/arsip/surat-masuk/'.$file_surat_masuk->hash_file));
                $file_surat_masuk->delete();
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
        $file_surat_masuk = FileSuratMasuk::findOrFail($id);
        $filePath = public_path("storage/arsip/surat-masuk/".$file_surat_masuk->hash_file);
        return response()->download($filePath, $file_surat_masuk->nama_file);
    }

    public function submit($id)
    {
        if(FileSuratMasuk::whereSuratMasukId($id)->count() > 0){
            $surat_masuk = SuratMasuk::findOrFail($id);
            $surat_masuk->is_submit = true;
            $surat_masuk->update();
            return redirect()->route('admin.transaksi.surat-masuk.index')->with('success','Surat masuk berhasil disubmit');
        }else{
            return back()->with('error','Harap mengupload file lampiran terlebih dahulu!');
        }
    }
}
