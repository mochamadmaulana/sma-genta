@extends('layouts.admin', ['title' => 'Dashboard','icon' => 'fas fa-home'])

@section('content')
<div class="jumbotron {{ Auth::user()->dark_mode == true ? 'bg-dark' : '' }}">
    <h1 class="display-5">Hallo, {{ Auth::user()->nama_lengkap }}</h1>
    <p class="lead">Selamat datang di Aplikasi Pengelolaan Surat dan Kearsipan <b class="font-italic">SMA Genta Syaputra,...</b></p>
    <hr class="my-4">

    <h4 class="display-5"><i class="fas fa-exclamation-circle mr-1"></i> Visi & Misi SMA GENTA SYAPUTRA</h5>
    <p>&emsp;  Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
</div>

<div class="row justify-content-center">
    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-envelope-open-text"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Surat Masuk</span>
                <span class="info-box-number">0</span>
            </div>
        </div>
    </div>

    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Surat Keluar</span>
                <span class="info-box-number">0</span>
            </div>
        </div>
    </div>

    <div class="col-4 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Pengguna</span>
                <span class="info-box-number">0</span>
            </div>
        </div>
    </div>

</div>
@endsection
