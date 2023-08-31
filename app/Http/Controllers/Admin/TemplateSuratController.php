<?php

namespace App\Http\Controllers\Admin;

use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\FileTemplateSurat;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TemplateSuratController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $file_template_surat = FileTemplateSurat::with('jenis_surat')->latest()->get();
            return DataTables::of($file_template_surat)->addIndexColumn()
            ->removeColumn('id')
            ->editColumn('ukuran',function($data){
                return number_format($data->ukuran_file / 1024,'0',',','.').'Kb';
            })
            ->editColumn('jenis',function($data){
                return '<span class="badge badge-primary">'.$data->jenis_surat->nama_jenis.'</span>';
            })
            ->addColumn('action','admin.template-surat.action')
            ->rawColumns(['action','ukuran','jenis'])
            ->tojson();
        }
        return view('admin.template-surat.index');
    }

    public function create()
    {
        $jenis_surat = JenisSurat::latest()->get();
        return view('admin.template-surat.tambah',[
            'jenis_surat' => $jenis_surat
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file_template" => ["required","file","mimes:docx,doc,xls,xlsx,csv,ppt,pptx","file","max:4096"],
            "nama_file" => ["required","max:200"],
            "jenis" => ["required"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal disimpan!')->withErrors($validator)->withInput();
        }
        $file_template = $request->file('file_template');
        $hash_file = $file_template->hashName();
        $mime_type = $file_template->getClientMimeType();
        $extensi = $file_template->getClientOriginalExtension();
        $ukuran_file = $file_template->getSize();
        $file_template->storeAs('public/template-surat',$hash_file);
        FileTemplateSurat::create([
            "jenis_surat_id" => $request->jenis,
            "nama_file" => $request->nama_file.'.'.$extensi,
            'hash_file' => $hash_file,
            'mime_type' => $mime_type,
            'extensi' => $extensi,
            'ukuran_file' => $ukuran_file,

        ]);
        return redirect()->route('admin.template-surat.index')->with('success','Data berhasil disimpan');
    }

    public function download($id)
    {
        $file_template_surat = FileTemplateSurat::findOrFail($id);
        $filePath = public_path("storage/template-surat/".$file_template_surat->hash_file);
        return response()->download($filePath, $file_template_surat->nama_file);
    }

    public function destroy($id)
    {
        $file_template_surat = FileTemplateSurat::findOrFail($id);
        if($file_template_surat->count() > 0){
            unlink(storage_path('app/public/template-surat/'.$file_template_surat->hash_file));
            $file_template_surat->delete();
            return back()->with('success','Data berhasil dihapus');
        }else{
            return back()->with('error','Data gagal dihapus!');
        }
    }
}
