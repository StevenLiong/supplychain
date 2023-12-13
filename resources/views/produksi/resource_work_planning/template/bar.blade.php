@extends('produksi.resource_work_planning.template.layout')
@section('sidebar')
    <div class="iq-sidebar  sidebar-default ">
        <div class="iq-sidebar-logo d-flex justify-content-left align-items-center">
            <a href="/Dashboard" class="header-logo">
                <img src="/templatetrafindo/assets/images/logotrafindo.png" style="width: 10rem;height:5rem;"
                    alt="logo_trafoindo">
            </a>
            <div class="iq-menu-bt-sidebar ml-0">
                <i class="las la-bars wrapper-menu"></i>
            </div>
        </div>
        <div class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li class="{{ Request::is('resource_work_planning/dashboard') || Request::is('resource_work_planning/dashboard/data/process-periode') ? 'active' : '' }}">
                        <a href="/resource_work_planning/dashboard" class="svg-icon">
                            <i style="font-size: 20px" class="fa-solid fa-chart-simple"></i><span
                                class="ml-4">Dashboards</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/Work-Load') ? 'active' : '' }}">
                        <a href="/resource_work_planning/Work-Load" class="svg-icon">
                            <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                            <span class="ml-4">Work Load</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/PL2/') ? 'active' : '' }}">
                        <a href="#PL2" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="font-size: 20px" class="fa-solid fa-industry"></i>
                            <span class="ml-4">PL 2</span>
                            <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                            <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="PL2" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            {{-- <li class="{{ Request::is('resource_work_planning/PL2/Work-Load') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL2/Work-Load" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                                    <span class="ml-4">Work Load</span>
                                </a>
                            </li> --}}
                            <li class="{{ Request::is('resource_work_planning/PL2/Kebutuhan') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL2/Kebutuhan" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-layer-group"></i>
                                    <span class="ml-4">Kebutuhan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('resource_work_planning/PL2/Rekomendasi') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL2/Rekomendasi" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-thumbs-up"></i>
                                    <span class="ml-4">Rekomendasi </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/PL3/') ? 'active' : '' }}">
                        <a href="#PL3" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="font-size: 20px" class="fa-solid fa-industry"></i>
                            <span class="ml-4">PL 3</span>
                            <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                            <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="PL3" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            {{-- <li class="{{ Request::is('resource_work_planning/PL3/Work-Load') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL3/Work-Load" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                                    <span class="ml-4">Work Load</span>
                                </a>
                            </li> --}}
                            <li class="{{ Request::is('resource_work_planning/PL3/Kebutuhan') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL3/Kebutuhan" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-layer-group"></i>
                                    <span class="ml-4">Kebutuhan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('resource_work_planning/PL3/Rekomendasi') ? 'active' : '' }}">
                                <a href="/resource_work_planning/PL3/Rekomendasi" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-thumbs-up"></i>
                                    <span class="ml-4">Rekomendasi </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/CT-VT/') ? 'active' : '' }}">
                        <a href="#CT-VT" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="font-size: 20px" class="fa-solid fa-industry"></i>
                            <span class="ml-4">CT / VT</span>
                            <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                            <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="CT-VT" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            {{-- <li class="{{ Request::is('resource_work_planning/CT-VT/Work-Load') ? 'active' : '' }}">
                                <a href="/resource_work_planning/CT-VT/Work-Load" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                                    <span class="ml-4">Work Load</span>
                                </a>
                            </li> --}}
                            <li class="{{ Request::is('resource_work_planning/CT-VT/Kebutuhan') ? 'active' : '' }}">
                                <a href="/resource_work_planning/CT-VT/Kebutuhan" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-layer-group"></i>
                                    <span class="ml-4">Kebutuhan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('resource_work_planning/CT-VT/Rekomendasi') ? 'active' : '' }}">
                                <a href="/resource_work_planning/CT-VT/Rekomendasi" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-thumbs-up"></i>
                                    <span class="ml-4">Rekomendasi </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/Dry/') ? 'active' : '' }}">
                        <a href="#Dry" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="font-size: 20px" class="fa-solid fa-industry"></i>
                            <span class="ml-4">DRY</span>
                            <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                            <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="Dry" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            {{-- <li class="{{ Request::is('resource_work_planning/Dry/Work-Load') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Dry/Work-Load" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                                    <span class="ml-4">Work Load</span>
                                </a>
                            </li> --}}
                            <li class="{{ Request::is('resource_work_planning/Dry/Kebutuhan') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Dry/Kebutuhan" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-layer-group"></i>
                                    <span class="ml-4">Kebutuhan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('resource_work_planning/Dry/Rekomendasi') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Dry/Rekomendasi" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-thumbs-up"></i>
                                    <span class="ml-4">Rekomendasi </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/Repair/') ? 'active' : '' }}">
                        <a href="#Repair" class="collapsed" data-toggle="collapse" aria-expanded="false">
                            <i style="font-size: 20px" class="fa-solid fa-industry"></i>
                            <span class="ml-4">REPAIR</span>
                            <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                            <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                        </a>
                        <ul id="Repair" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                            {{-- <li class="{{ Request::is('resource_work_planning/Repair/Work-Load') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Repair/Work-Load" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-clipboard-list"></i>
                                    <span class="ml-4">Work Load</span>
                                </a>
                            </li> --}}
                            <li class="{{ Request::is('resource_work_planning/Repair/Kebutuhan') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Repair/Kebutuhan" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-layer-group"></i>
                                    <span class="ml-4">Kebutuhan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('resource_work_planning/Repair/Rekomendasi') ? 'active' : '' }}">
                                <a href="/resource_work_planning/Repair/Rekomendasi" class="svg-icon">
                                    <i style="font-size: 20px" class="fa-solid fa-thumbs-up"></i>
                                    <span class="ml-4">Rekomendasi </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('resource_work_planning/Kalkulasi-SDM') ? 'active' : '' }}">
                        <a href="/resource_work_planning/Kalkulasi-SDM" class="svg-icon">
                            <i style="font-size: 20px" class="fa-solid fa-calculator"></i>
                            <span class="ml-4">KALKULASI<br>SDM</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="pt-5 pb-2"></div>
        </div>
    </div>
@endsection
@section('navbar')
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                    <i class="ri-menu-line wrapper-menu"></i>
                    <a href="../backend/index.html" class="header-logo">
                    </a>
                </div>
                <div class="navbar-breadcrumb">
                    <h5>Supply Chain DX - Planning Full-Cycle</h5>
                </div>
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-label="Toggle navigation">
                        <i class="ri-menu-3-line"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-list align-items-center">


                            <li class="nav-item nav-icon dropdown caption-content">
                                <a href="#" class="search-toggle dropdown-toggle  d-flex align-items-center"
                                    id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img src="/templatetrafindo/assets/images/user/1.jpg" class="img-fluid rounded-circle"
                                        alt="user">
                                    <div class="caption ml-3">
                                        <h6 class="mb-0 line-height">$username<i class="las la-angle-down ml-2"></i></h6>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right border-none"
                                    aria-labelledby="dropdownMenuButton">
                                    <li class="dropdown-item d-flex svg-icon">
                                        <svg class="svg-icon mr-0 text-primary" id="h-01-p" width="20"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <a href="../app/user-profile.html">My Profile</a>
                                    </li>
                                    <li class="dropdown-item d-flex svg-icon">
                                        <svg class="svg-icon mr-0 text-primary" id="h-02-p" width="20"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <a href="../app/user-profile-edit.html">Edit Profile</a>
                                    </li>
                                    <li class="dropdown-item  d-flex svg-icon border-top">
                                        <svg class="svg-icon mr-0 text-primary" id="h-05-p" width="20"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
@endsection
@section('footer')
    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 text-center     text-primary">
                    <span class="mr-1"> Supply Chain Team </span>
                </div>
                <div class="col-lg-6 text-right text-primary">
                    <span class="mr-1">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>©
                    </span> <a href="#" class="">MSIB TRAFINDO BATCH 5 1</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- resources  -->
@endsection
