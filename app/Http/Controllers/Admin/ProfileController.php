<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => ['required','max:100'],
            'username' => ['required','max:25','unique:users,username,'.auth()->user()->id.',id'],
            'email' => ['required','unique:users,email,'.auth()->user()->id.',id'],
            'alamat' => ['nullable','max:225'],
            'nip' => ['nullable','numeric'],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Profile gagal diupdate!')->withErrors($validator)->withInput();
        }
        User::findOrFail(auth()->user()->id)
            ->update([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nip_pegawai' => $request->nip,
            ]);
        return redirect()->route('admin.profile.index')->with('success','Profile berhasil diupdate');
    }

    public function upload_photo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file_photo' => ['required','file','mimes:png,jpg,jpeg','max:2048'],
        ]);
        if ($validator->fails()) {
            return back()->with('error','Photo profile gagal diupload!')->withErrors($validator)->withInput();
        }
        $file_photo = $request->file('file_photo');
        $file_name = $file_photo->hashName();
        $path = $file_photo->storeAs('public/image/avatar',$file_name);
        $resize_file = 'public/image/avatar/resize/'.$file_name;
        Storage::copy($path, $resize_file);
        Image::make(storage_path('app/'.$resize_file))
                ->fit(340, 340) // Crop size: width 800px, height 600px
                ->save();
        User::findOrFail(auth()->user()->id)
            ->update([
                'photo_profile' => $file_name
            ]);
        return back()->with('success','Photo profile berhasil diupload');
    }

    public function edit_photo(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'file_photo_edit' => ['required','file','mimes:png,jpg,jpeg','max:2048'],
        ],
        [
            'file_photo_edit.required' => 'The file photo field is required.',
            'file_photo_edit.max' => 'The file photo must not be greater than 2048 kilobytes.',
            'file_photo_edit.file' => 'The file photo must be a file.',
            'file_photo_edit.mimes' => 'The file photo must be a file of type: png, jpg, jpeg.',
        ]);
        if ($validator->fails()) {
            return back()->with('error','Photo profile gagal diedit!')->withErrors($validator)->withInput();
        }
        $user = User::findOrFail(auth()->user()->id);
        $file_photo = $request->file('file_photo_edit');
        $hash_name = $file_photo->hashName();
        if (File::exists(storage_path('app/public/image/avatar/'.auth()->user()->photo_profile))){
            unlink(storage_path('app/public/image/avatar/'.auth()->user()->photo_profile));
            unlink(storage_path('app/public/image/avatar/resize/'.auth()->user()->photo_profile));
            $path = $file_photo->storeAs('public/image/avatar',$hash_name);
            $resize_file = 'public/image/avatar/resize/'.$hash_name;
            Storage::copy($path, $resize_file);
            Image::make(storage_path('app/'.$resize_file))
                    ->fit(340, 340) // Crop size: width 800px, height 600px
                    ->save();
            $user->photo_profile = $hash_name;
            $user->update();
            return back()->with('success','Photo profile berhasil diedit');
        }else{
            return back()->with('error','Terjadi kesalahan, silahkan coba kembali!');
        }
    }

    public function destroy_photo()
    {
        if (File::exists(storage_path('app/public/image/avatar/'.auth()->user()->photo_profile))){
            unlink(storage_path('app/public/image/avatar/'.auth()->user()->photo_profile));
            unlink(storage_path('app/public/image/avatar/resize/'.auth()->user()->photo_profile));
            User::findOrFail(auth()->user()->id)
                ->update([
                    'photo_profile' => null
                ]);
            return back()->with('success','Photo profile berhasil dihapus');
        }else{
            return back()->with('error','Terjadi kesalahan, silahkan coba kembali!');
        }
    }

    public function upload_ktp(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'nik_ktp' => ['required','numeric','unique:users,nik_ktp'],
            'file_ktp' => ['required','file','mimes:png,jpg,jpeg,pdf','max:2048'],
        ]);
        if ($validator->fails()) {
            return back()->with('error','KTP gagal diupload!')->withErrors($validator)->withInput();
        }
        $file_ktp = $request->file('file_ktp');
        $hash_name = $file_ktp->hashName();
        $file_ktp->storeAs('public/image/ktp',$hash_name);
        User::findOrFail(auth()->user()->id)
            ->update([
                'nik_ktp' => $request->nik_ktp,
                'photo_ktp' => $hash_name
            ]);
        return back()->with('success','KTP berhasil diupload');
    }

    public function edit_ktp(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'nik_ktp_edit' => ['required','numeric','unique:users,nik_ktp,'.auth()->user()->id.',id'],
            'file_ktp_edit' => ['nullable','file','mimes:png,jpg,jpeg,pdf','max:2048'],
        ],
        [
            'nik_ktp_edit.required' => 'Nik ktp tidak boleh kosong.',
            'nik_ktp_edit.unique' => 'Nik ktp tidak unique dan telah digunakan.',
            'nik_ktp_edit.numeric' => 'Nik ktp harus bertipe number.',
            'file_ktp_edit.max' => 'File ktp maksimal berukuran 2048kb',
        ]);
        if ($validator->fails()) {
            return back()->with('error','Ktp gagal diupdate!')->withErrors($validator)->withInput();
        }
        $user = User::findOrFail(auth()->user()->id);
        if($request->hasFile('file_ktp_edit')){
            $file_lama = auth()->user()->photo_ktp;
            $file_ktp = $request->file('file_ktp_edit');
            $hash_name = $file_ktp->hashName();
            if (File::exists(storage_path('app/public/image/ktp/'.$file_lama))){
                unlink(storage_path('app/public/image/ktp/'.$file_lama));
                $file_ktp->storeAs('public/image/ktp',$hash_name);
                $user->photo_ktp = $hash_name;
            }else{
                return back()->with('error','Terjadi kesalahan, silahkan coba kembali!');
            }
        }
        $user->nik_ktp = $request->nik_ktp_edit;
        $user->update();
        return back()->with('success','Ktp berhasil diupdate');
    }

    public function destroy_ktp()
    {
        $user = User::findOrFail(auth()->user()->id);
        if (File::exists(storage_path('app/public/image/ktp/'.$user->photo_ktp))){
            unlink(storage_path('app/public/image/ktp/'.$user->photo_ktp));
            //File::delete($image_path);
            $user->update([
                'nik_ktp' => null,
                'photo_ktp' => null
            ]);
            return back()->with('success','Ktp berhasil dihapus');
        }else{
            return back()->with('error','Terjadi kesalahan, silahkan coba kembali!');
        }
    }

    public function edit_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'konfirmasi_password' => 'required_with:password|same:password'
        ]);
        if ($validator->fails()) {
            return back()->with('error','Password gagal diedit!')->withErrors($validator)->withInput();
        }
        User::findOrFail(auth()->user()->id)
            ->update([
                'password' => Hash::make($request->password)
            ]);
        return back()->with('success','Password berhasil diedit');
    }
}
