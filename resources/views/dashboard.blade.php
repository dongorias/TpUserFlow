<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <script type="text/javascript" src="{{ asset('chart.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <title>Laravel Dashboard</title>
    <style>
        /* Cacher le menu desktop sur les petits écrans */
        @media (max-width: 767px) {
            .desktop-sidebar {
                display: none !important;
            }
        }

        /* Cacher le menu mobile sur les grands écrans */
        @media (min-width: 768px) {
            .offcanvas-start {
                display: none !important;
            }
            .mobile-menu-toggle {
                display: none !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar pour grands écrans -->
        <nav class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar desktop-sidebar">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <img src="{{ asset('img.png') }}" class="img-fluid" style="max-height: 150px;" alt="Logo">
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="bi bi-people me-2"></i>Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menus.index') }}">
                            <i class="bi bi-list-ul me-2"></i>Menu
                        </a>
                        <ul class="nav flex-column ps-4">
                            @foreach ($navbars as $navbarItem)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('menus.content', ['id'=>$navbarItem->id]) }}">
                                        {{ $navbarItem->intitule }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sleep.index') }}">
                            <i class="bi bi-people me-2"></i>Suivi Sommeil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Offcanvas Menu pour mobile -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="bi bi-people me-2"></i>Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menus.index') }}">
                            <i class="bi bi-list-ul me-2"></i>Menu
                        </a>
                        <ul class="nav flex-column ps-4">
                            @foreach ($navbars as $navbarItem)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('menus.content', ['id'=>$navbarItem->id]) }}">
                                        {{ $navbarItem->intitule }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                        </a>
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Topbar with Menu Toggle -->
        <nav class="navbar navbar-expand-md navbar-light bg-white mobile-menu-toggle d-md-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>

        <!-- Main content area -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Page header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de Bord</h1>
                <div>
                    <h5 class="card-title">Bienvenue, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h5>
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();">
                        Déconnexion
                    </a>
                    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Dynamic content -->
            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
