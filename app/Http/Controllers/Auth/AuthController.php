<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_store(Request $request)
    {
        $request->validate([
            'email_username' => ['required'],
            'password' => ['required'],
        ]);

        $email_username = strtolower($request->email_username);
        $user = User::with('jabatan')->where('email', $email_username)->orWhere('username', $email_username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            if($user->status == 'aktif'){
                Auth::login($user);
                if ($user->role === 'Admin') {
                    return redirect()->route('admin.dashboard')->with('login_success', 'Selamat bekerja, '.$user->nama_lengkap);
                }else {
                    return redirect()->route('kepala-sekolah.dashboard')->with('login_success', 'Selamat bekerja '.$user->nama_lengkap);
                }
            }else{
                return back()->with('error', 'Akun anda tidak aktif, harap hubungi admin!');
            }
        } else {
            return back()->with('error', 'Harap periksa kembali email/username dan password anda!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with("success", "Logout berhasil, sampai jumpa kembali..");
    }
}
