<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanSuratKeluarController extends Controller
{
    public function index()
    {
        return back()->with('error','Fitur masih tahap development!');
    }
}
