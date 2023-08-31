<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jabatan = Jabatan::orderBy('id','DESC')->get();
            return DataTables::of($jabatan)->addIndexColumn()
            ->removeColumn('id')
            ->addColumn('action','admin.jabatan.action')
            ->rawColumns(['action'])
            ->tojson();
        }
        return view('admin.jabatan.index');
    }

    public function create()
    {
        return view('admin.jabatan.tambah');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => ['required','max:50','unique:jabatans,nama_jabatan']
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal ditambahkan !')->withErrors($validator)->withInput();
        }
        Jabatan::create(["nama_jabatan" => $request->nama_jabatan]);
        return redirect()->route('admin.jabatan.index')->with('success','Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::whereId($id)->first();
        if($jabatan->nama_jabatan == 'Kepala Sekolah' || $jabatan->nama_jabatan == 'Staff TU' || $jabatan->nama_jabatan == 'Kepala TU'){
            return back()->with('error','Jabatan tersebut tidak dapat diedit!');
        }

        return view('admin.jabatan.edit',compact('jabatan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => ['required','max:50']
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal diedit !')->withErrors($validator)->withInput();
        }
        $jabatan = Jabatan::whereId($id)->first();
        if($request->nama_jabatan != $jabatan->nama_jabatan){
            if(Jabatan::where('nama_jabatan',$request->nama_jabatan)->first()){
                return back()->with('error','Nama jabatan sudah digunakan !');
            }else{
                $jabatan->nama_jabatan = $request->nama_jabatan;
                $jabatan->update();
                return redirect()->route('admin.jabatan.index')->with('success','Data berhasil diedit');
            }
        }
        return redirect()->route('admin.jabatan.index')->with('success','Tidak ada data yang diedit !');
    }

    public function destroy($id)
    {
        if ($id) {
            $jabatan = Jabatan::whereId($id)->first();
            if($jabatan->nama_jabatan == 'Kepala Sekolah' || $jabatan->nama_jabatan == 'Staff TU' || $jabatan->nama_jabatan == 'Kepala TU'){
                return back()->with('error','Jabatan tersebut tidak dapat dihapus!');
            }

            $jabatan->delete();
            return back()->with('success','Data berhasil dihapus!');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }
}
