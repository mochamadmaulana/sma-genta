<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class JenisSuratController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jenis_surat = JenisSurat::orderBy('id','DESC')->get();
            return DataTables::of($jenis_surat)->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('action','admin.jenis-surat.action')
            ->rawColumns(['action'])
            ->tojson();
        }
        return view('admin.jenis-surat.index');
    }

    public function create()
    {
        return view('admin.jenis-surat.tambah');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => ['required','max:50','unique:jenis_surats,nama_jenis']
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal disimpan!')->withErrors($validator)->withInput();
        }
        JenisSurat::create(["nama_jenis" => $request->nama_jenis]);
        return redirect()->route('admin.jenis-surat.index')->with('success','Data berhasil simpan');
    }

    public function edit($id)
    {
        $jenis_surat = JenisSurat::whereId($id)->first();
        return view('admin.jenis-surat.edit',compact('jenis_surat'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => ['required','max:50']
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal diupdate!')->withErrors($validator)->withInput();
        }
        JenisSurat::whereId($id)->update([
            'nama_jenis' => $request->nama_jenis
        ]);
        return redirect()->route('admin.jenis-surat.index')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisSurat::findOrFail($id)->delete();
        return back()->with('success','Data berhasil dihapus!');
    }
}
