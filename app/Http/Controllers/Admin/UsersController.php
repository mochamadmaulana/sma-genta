<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::with('jabatan')->latest()->get();
            return DataTables::of($user)->addIndexColumn()
            ->removeColumn('id')
            ->editColumn('status',function($row){
                if($row->status == 'aktif'){
                    return '<span class="badge badge-success">Aktif</span>';
                }else{
                    return '<span class="badge badge-danger">Nonaktif</span>';
                }
            })
            ->addColumn('action','admin.users.action')
            ->rawColumns(['action','status'])
            ->tojson();
        }
        $sampah = User::onlyTrashed()->get();
        return view('admin.users.index',[
            'sampah' => $sampah->count()
        ]);
    }

    public function create()
    {
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('admin.users.tambah',compact('jabatan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama_lengkap" => ["required","max:200"],
            "username" => ["required","max:25","unique:users,username"],
            "email" => ["required","max:200","unique:users,email"],
            "password" => ["required","min:6"],
            "jabatan" => ["required"],
            "role" => ["required"],
            "photo_profile" => ["nullable","file","mimes:jpg,jpeg,png,gif","max:2048"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal ditambahkan!')->withErrors($validator)->withInput();
        }
        $user = new User();
        if($request->file('photo_profile')){
            $photo_profile = $request->file('photo_profile');
            $nama_photo = $photo_profile->hashName();
            $path = $photo_profile->storeAs('public/image/avatar',$nama_photo);
            $resize_file = 'public/image/avatar/resize/'.$nama_photo;
            Storage::copy($path, $resize_file);
            Image::make(storage_path('app/'.$resize_file))
                ->fit(340, 340) // Crop size: width 800px, height 600px
                ->save();
            $user->photo_profile = $nama_photo;
        }
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = strtolower($request->username);
        $user->email = strtolower($request->email);
        $user->jabatan_id = $request->jabatan;
        $user->status = 'aktif';
        $user->role = $request->role;
        $user->alamat = $request->alamat;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.users.index')->with('success','Data berhasil ditambahkan');
    }

    public function show($id)
    {
        return back()->with('error','Comming soon!');
    }

    public function edit($id)
    {
        $user = User::with('jabatan')->findOrFail($id);
        $jabatan = Jabatan::orderBy('id','DESC')->get();
        return view('admin.users.edit',compact('user','jabatan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "nama_lengkap" => ["required","max:200"],
            "username" => ["required","max:25","max:25","unique:users,username,".$id.",id"],
            "email" => ["required","max:200","unique:users,email,".$id.",id"],
            "jabatan" => ["required"],
            "status" => ["required"],
            "role" => ["required"],
            "photo_profile" => ["nullable","file","mimes:jpg,jpeg,png,gif","max:2048"],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Data gagal diupdate!')->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        if($request->file('photo_profile')){
            $photo_lama = $user->photo_profile;
            $photo_baru = $request->file('photo_profile');
            $nama_photo = $photo_baru->hashName();
            if(!empty($photo_lama)){
                unlink(storage_path('app/public/image/avatar/'.$photo_lama));
                unlink(storage_path('app/public/image/avatar/resize/'.$photo_lama));
            }
            $path = $photo_baru->storeAs('public/image/avatar',$nama_photo);
            $resize_file = 'public/image/avatar/resize/'.$nama_photo;
            Storage::copy($path, $resize_file);
            Image::make(storage_path('app/'.$resize_file))
                ->fit(340, 340) // Crop size: width 800px, height 600px
                ->save();
            $user->photo_profile = $nama_photo;
        }
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->jabatan_id = $request->jabatan;
        $user->status = $request->status;
        $user->role = $request->role;
        $user->alamat = $request->alamat;
        $user->update();
        return redirect()->route('admin.users.index')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->count() > 0){
            if ($user->photo_profile != null && File::exists(storage_path('app/public/image/avatar/'.$user->photo_profile))){
                unlink(storage_path('app/public/image/avatar/'.$user->photo_profile));
                unlink(storage_path('app/public/image/avatar/resize/'.$user->photo_profile));
            }
            $user->status = 'nonaktif';
            $user->update();
            $user->delete();
            return back()->with('success','Data berhasil dihapus');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }

    public function edit_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "password" => ['min:6'],
            "konfirmasi_password" => ['required','same:password','min:6'],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Password gagal diupdate!')->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        if($user){
            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('success','Password berhasil diupdate');
        }else{
            return back()->with('error','Terjadi kesalahan, harap coba kembali!');
        }
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            $user = User::with('jabatan')->onlyTrashed()->latest()->get();
            return DataTables::of($user)->addIndexColumn()
            ->removeColumn('id')
            ->editColumn('status',function($row){
                if($row->status == 'aktif'){
                    return '<span class="badge badge-success">Aktif</span>';
                }else{
                    return '<span class="badge badge-danger">Nonaktif</span>';
                }
            })
            ->addColumn('action','admin.users.trash-action')
            ->rawColumns(['action','status'])
            ->tojson();
        }
        return view('admin.users.trash');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        if($user->count() > 0){
            $user->status = 'aktif';
            $user->update();
            $user->restore();
            return back()->with('success','Data berhasil dipulihkan');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }

    public function destroy_permanent($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        if($user->count() > 0){
            if ($user->photo_profile != null && File::exists(storage_path('app/public/image/avatar/'.$user->photo_profile))){
                unlink(storage_path('app/public/image/avatar/'.$user->photo_profile));
                unlink(storage_path('app/public/image/avatar/resize/'.$user->photo_profile));
            }
            $user->forceDelete();
            return back()->with('success','Data berhasil dihapus permanent');
        }else{
            return back()->with('error','Data tidak ditemukan!');
        }
    }
}
