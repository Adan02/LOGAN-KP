<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LOGAN | @yield('title')</title>
    {{--
    <link href="{{asset('img/favicon.png')}}" rel="icon"> --}}
    {{--
    <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/mycss.css') }}"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet"> --}}
    {{--
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('css/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('css/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/logan/" class="logo d-flex align-items-center">
                {{-- <img src="{{asset('img/logo.png')}}" alt=""> --}}
                <span class="d-lg-block">LOGAN</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:void(0)" data-bs-toggle="dropdown">
                        {{-- <img src="{{ asset('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle"> --}}
                        <i class="fa-solid fa-user fs-5"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->username }}</h6>
                            <span>{{ Auth::user()->role->name }}</span>
                        </li>
                        <li class="text-center">
                            <a class="dropdown-item d-flex justify-content-center align-items-center" href="/logan/logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="{{ request()->is('logan') ? 'nav-link' : 'nav-link collapsed' }}" href="/logan/">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->is('logan/input-data*') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#input-barangMasuk" data-bs-toggle="collapse" href="javascript:void(0)">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Input Barang</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="{{ request()->is('logan/input-data*') ? 'sidebar-nav2 nav-content collapse show' : 'sidebar-nav2 nav-content collapse' }}" data-bs-parent="#sidebar-nav" id="input-barangMasuk">
                    <li>
                        <a class="{{ request()->is('logan/input-data/sfp-masuk') || request()->is('logan/input-data/patchcord-masuk') || request()->is('logan/input-data/modul-masuk') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#input-barang-masuk" data-bs-toggle="collapse" href="javascript:void(0)">
                            <i class="bi bi-circle"></i>
                            <span>Barang Masuk</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>
                        <ul id="input-barang-masuk" class="{{ request()->is('logan/input-data/sfp-masuk') || request()->is('logan/input-data/patchcord-masuk') || request()->is('logan/input-data/modul-masuk') ? 'nav-content collapse ps-4 show' : 'nav-content collapse ps-4' }}" data-bs-parent="#input-barangMasuk">
                            <li>
                                <a class="{{ request()->is('logan/input-data/sfp-masuk') ? 'active' : '' }}" href="/logan/input-data/sfp-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>SFP</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/input-data/patchcord-masuk') ? 'active' : '' }}" href="/logan/input-data/patchcord-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Patchcord</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/input-data/modul-masuk') ? 'active' : '' }}" href="/logan/input-data/modul-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Modul</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="{{ request()->is('logan/input-data/barang-keluar') ? 'active' : '' }}" href="/logan/input-data/barang-keluar">
                            <i class="bi bi-circle"></i>
                            <span>Barang Keluar</span>
                        </a>
                    </li>
                    @if (auth()->user()->role_id === 1)
                        <li>
                            <a class="{{ request()->is('logan/input-data/arsip') ? 'active' : '' }}" href="/logan/input-data/arsip">
                                <i class="bi bi-circle"></i>
                                <span>Arsip</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item">
                <a class="{{ request()->is('logan/list-data*') && !request()->is('logan/list-data/sfp-edit*') && !request()->is('logan/list-data/patchcord-edit*') && !request()->is('logan/list-data/modul-edit*') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#list-barang" data-bs-toggle="collapse" href="javascript:void(0)">
                    <i class="bi bi-grid-1x2"></i>
                    <span>List Barang</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="{{ request()->is('logan/list-data*') && !request()->is('logan/list-data/sfp-edit*') && !request()->is('logan/list-data/patchcord-edit*') && !request()->is('logan/list-data/modul-edit*') ? 'sidebar-nav2 nav-content collapse show' : 'sidebar-nav2 nav-content collapse' }}" data-bs-parent="#sidebar-nav" id="list-barang">
                    <li>
                        <a class="{{ request()->is('logan/list-data/sfp-masuk') || request()->is('logan/list-data/patchcord-masuk') || request()->is('logan/list-data/modul-masuk') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#list-barang-masuk" data-bs-toggle="collapse" href="javascript:void(0)">
                            <i class="bi bi-circle"></i>
                            <span>Barang Masuk</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>
                        <ul id="list-barang-masuk" class="{{ request()->is('logan/list-data/sfp-masuk') || request()->is('logan/list-data/patchcord-masuk') || request()->is('logan/list-data/modul-masuk') ? 'nav-content collapse ps-4 show' : 'nav-content collapse ps-4' }}" data-bs-parent="#list-barang">
                            <li>
                                <a class="{{ request()->is('logan/list-data/sfp-masuk') ? 'active' : '' }}" href="/logan/list-data/sfp-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>SFP</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/list-data/patchcord-masuk') ? 'active' : '' }}" href="/logan/list-data/patchcord-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Patchcord</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/list-data/modul-masuk') ? 'active' : '' }}" href="/logan/list-data/modul-masuk">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Modul</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="{{ request()->is('logan/list-data/sfp-keluar') || request()->is('logan/list-data/patchcord-keluar') || request()->is('logan/list-data/modul-keluar') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#list-barang-keluar" data-bs-toggle="collapse" href="javascript:void(0)">
                            <i class="bi bi-circle"></i>
                            <span>Barang Keluar</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>
                        <ul id="list-barang-keluar" class="{{ request()->is('logan/list-data/sfp-keluar') || request()->is('logan/list-data/patchcord-keluar') || request()->is('logan/list-data/modul-keluar') ? 'nav-content collapse ps-4 show' : 'nav-content collapse ps-4' }}" data-bs-parent="#list-barang">
                            <li>
                                <a class="{{ request()->is('logan/list-data/sfp-keluar') ? 'active' : '' }}" href="/logan/list-data/sfp-keluar">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>SFP</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/list-data/patchcord-keluar') ? 'active' : '' }}" href="/logan/list-data/patchcord-keluar">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Patchcord</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/list-data/modul-keluar') ? 'active' : '' }}" href="/logan/list-data/modul-keluar">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Modul</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (auth()->user()->role_id === 1)
                        <li>
                            <a class="{{ request()->is('logan/list-data/arsip') ? 'active' : '' }}" href="/logan/list-data/arsip">
                                <i class="bi bi-circle"></i>
                                <span>Arsip</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item">
                <a class="{{ request()->is('logan/trash*') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#trash-list-barang" data-bs-toggle="collapse" href="javascript:void(0)">
                    <i class="bi bi-trash"></i>
                    <span>Trash</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul class="{{ request()->is('logan/trash*') ? 'sidebar-nav2 nav-content collapse show' : 'sidebar-nav2 nav-content collapse' }}" data-bs-parent="#sidebar-nav" id="trash-list-barang">
                    <li>
                        <a class="{{ request()->is('logan/trash/masuk*') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#trash-list-barang-masuk" data-bs-toggle="collapse" href="javascript:void(0)">
                            <i class="bi bi-circle"></i>
                            <span>Barang Masuk</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>
                        <ul id="trash-list-barang-masuk" class="{{ request()->is('logan/trash/masuk*') ? 'nav-content collapse ps-4 show' : 'nav-content collapse ps-4' }}" data-bs-parent="#trash-list-barang">
                            <li>
                                <a class="{{ request()->is('logan/trash/masuk/sfp-deleted-list') ? 'active' : '' }}" href="/logan/trash/masuk/sfp-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>SFP</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/trash/masuk/patchcord-deleted-list') ? 'active' : '' }}" href="/logan/trash/masuk/patchcord-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Patchcord</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/trash/masuk/modul-deleted-list') ? 'active' : '' }}" href="/logan/trash/masuk/modul-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Modul</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="{{ request()->is('logan/trash/keluar*') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#trash-list-barang-keluar" data-bs-toggle="collapse" href="javascript:void(0)">
                            <i class="bi bi-circle"></i>
                            <span>Barang Keluar</span>
                            <i class="bi bi-chevron-down ms-auto fs-6"></i>
                        </a>
                        <ul id="trash-list-barang-keluar" class="{{ request()->is('logan/trash/keluar*') ? 'nav-content collapse ps-4 show' : 'nav-content collapse ps-4' }}" data-bs-parent="#trash-list-barang">
                            <li>
                                <a class="{{ request()->is('logan/trash/keluar/sfp-keluar-deleted-list') ? 'active' : '' }}" href="/logan/trash/keluar/sfp-keluar-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>SFP</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/trash/keluar/patchcord-keluar-deleted-list') ? 'active' : '' }}" href="/logan/trash/keluar/patchcord-keluar-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Patchcord</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->is('logan/trash/keluar/modul-keluar-deleted-list') ? 'active' : '' }}" href="/logan/trash/keluar/modul-keluar-deleted-list">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Modul</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (auth()->user()->role_id === 1)
                        <li>
                            <a class="{{ request()->is('logan/trash/arsip-deleted-list') ? 'active' : '' }}" href="/logan/trash/arsip-deleted-list">
                                <i class="bi bi-circle"></i>
                                <span>Arsip</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if (auth()->user()->role_id === 1)
                <li class="nav-item">
                    <a class="{{ request()->is('logan/manajemen-akun') ? 'nav-link' : 'nav-link collapsed' }}" href="/logan/manajemen-akun">
                        <i class="bi bi-grid"></i>
                        <span>Manajemen Akun</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>

    <div id="main" class="main">
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Javascript Bundle with Popper --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/echarts.min.js') }}"></script>
    <script src="{{ asset('js/quill.min.js') }}"></script>
    <script src="{{ asset('js/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/validate.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/my_jquery.js') }}"></script>
    @yield('scripts')
</body>

</html>
