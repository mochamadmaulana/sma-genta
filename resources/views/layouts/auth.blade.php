<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? '' }} | {{ env('APP_NAME') ?? 'APP-SK' }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte') }}/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte') }}/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('assets/image/logo_login.png') }}" alt="Logo SMA Genta" class="img-circle">
            <h4>SMA Genta Syaputra</h4>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login untuk masuk aplikasi</p>

                @yield('content')

                {{-- <div class="text-center mt-3">
                    <p class="mb-1">
                        <a href="forgot-password.html">Lupa password...</a>
                    </p>
                </div> --}}
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/adminlte') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/adminlte') }}/dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/adminlte') }}/plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/adminlte') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    @if(session()->has('success'))
    <script>
    $(document).ready(function () {
        toastr.success('{{ session("success") }}')
    })
    </script>
    @endif
    @if(session()->has('error'))
    <script>
    $(document).ready(function () {
        toastr.error('{{ session("error") }}')
    })
    </script>
    @endif
</body>

</html>
