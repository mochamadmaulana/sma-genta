<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Icon title bar -->
    <link rel="shortcut icon" href="{{ asset('assets/image/logo_login.png') }}" type="image/png">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? '' }} | {{ env('APP_NAME') ?? 'APP-SK' }}</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/toastr/toastr.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>

<body class="hold-transition {{ Auth::user()->dark_mode == true ? 'dark-mode' : '' }} sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <h4 class="brand-text font-weight-light"><b>SMA</b> Genta Syaputra</h4>
            <img src="{{ asset('assets/adminlte/dist/img/loading-spiner.gif') }}" alt="Loading..." height="100" width="100">
        </div> --}}

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand {{ Auth::user()->dark_mode == true ? 'navbar-dark' : 'navbar-white navbar-light' }}">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline mr-2" {{ Auth::user()->dark_mode == true ? 'style="color: black"' : '' }}>{{ Auth::user()->nama_lengkap ?? 'Nama Lengkap User' }}</span>
                        @if(!empty(Auth::user()->photo_profile))
                        <img src="{{ asset('storage/image/avatar/resize/'.Auth::user()->photo_profile) }}" class="user-image img-circle elevation-2" alt="Avatar">
                        @else
                        <img src="{{ asset('assets/image/default.jpg') }}" class="user-image img-circle elevation-2" alt="Avatar">
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- Avatar -->
                        <li class="user-header bg-secondary">
                            @if(!empty(Auth::user()->photo_profile))
                            <img src="{{ asset('storage/image/avatar/resize/'.Auth::user()->photo_profile) }}" class="img-circle elevation-2" alt="Avatar">
                            @else
                            <img src="{{ asset('assets/image/default.jpg') }}" class="img-circle elevation-2" alt="Avatar">
                            @endif

                            <p>
                                {{ Auth::user()->nama_lengkap ?? 'Nama Lengkap' }}
                                <small>{{ Auth::user()->jabatan->nama_jabatan ?? 'Jabatan' }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="{{ route('admin.profile.index') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-user mr-1"></i> Profile</a>
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-danger float-right shadow-sm"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="javascript:void(0)" class="brand-link">
                <img src="{{ asset('assets/image/logo_login.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-2" style="opacity: .8">
                <span class="brand-text font-weight-light ml-3">APP-SK GENTA<sup class="ml-2">V1</sup></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->nama_lengkap ?? 'Nama Lengkap' }}</a>
                        <small class="text-success">
                            <i>{{ Auth::user()->role }}</i>
                        </small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('kepala-sekolah.dashboard') }}"
                                class="nav-link {{ (request()->is('kepala-sekolah/dashboard')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">MANAJEMEN SURAT</li>

                        <!-- Transaksi Surat -->
                        <li class="nav-item {{ Request::segment(2) == 'transaksi' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::segment(2) == 'transaksi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-mail-bulk"></i>
                                <p>
                                    Transaksi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kepala-sekolah.transaksi.surat-masuk.index') }}" class="nav-link {{ Request::is('kepala-sekolah/transaksi/surat-masuk*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kepala-sekolah.transaksi.surat-keluar.index') }}" class="nav-link {{ Request::is('kepala-sekolah/transaksi/surat-keluar*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Arsip Surat -->
                        <li class="nav-item {{ Request::segment(2) == 'arsip' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::segment(2) == 'arsip' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Arsip
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kepala-sekolah.arsip.surat-masuk.index') }}" class="nav-link {{ Request::is('kepala-sekolah/arsip/surat-masuk*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('kepala-sekolah.arsip.surat-keluar.index') }}" class="nav-link {{ Request::is('kepala-sekolah/arsip/surat-keluar*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Laporan Surat -->
                        <li class="nav-item {{ Request::segment(2) == 'laporan' ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::segment(2) == 'laporan' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ Request::is('kepala-sekolah/laporan/surat-masuk*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link {{ Request::is('kepala-sekolah/laporan/surat-keluar*') ? 'active' : '' }}">
                                        <i class="far fa-circle text-sm nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">PENGATURAN</li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('kepala-sekolah.profile.index') }}" class="nav-link {{ request()->is('kepala-sekolah/profile*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <!-- Logout -->
                        <li class="nav-item mb-5">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><i class="{{ $icon ?? '' }}"></i> {{ $title ?? '' }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @stack('breadcrumb')
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Small boxes (Stat box) -->
                    @yield('content')
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://smagentasyaputra.sch.id/" target="_blank">SMA GENTA SYAPUTRA</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Versi 1</b>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @stack('modal')

    <!-- jQuery -->
    <script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/adminlte/dist/js/adminlte.min.js') }}"></script>

    @stack('js')

    @if(session()->has('login_success'))
    <script>
        $(document).ready(function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil...',
                text: '{{ session("login_success") }}',
                timer: 4000,
            })
        })
    </script>
    @endif

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
