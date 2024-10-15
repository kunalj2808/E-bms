<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>E-BMS Dashboard </title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/libs/fontawesome-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.2.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.2.3') }}">
    <style>
        .user-avatars {
            width: 100px;
            /* Set the width of the avatar */
            height: 100px;
            /* Set the height of the avatar */
            overflow: hidden;
            /* Hide the overflow */
            border-radius: 50%;
            /* Make the container circular */
            display: flex;
            align-items: center;
            /* Center the image vertically */
            justify-content: center;
            /* Center the image horizontally */
        }

        .user-avatar.sm {
            height: 32px;
            width: 32px;
            font-size: 12px;
        }

        .user-avatars img {
            width: 100%;
            /* Make the image take the full width */
            height: auto;
            /* Keep the aspect ratio */
            border-radius: 50%;
            /* Make the image circular */
            object-fit: cover;
            /* Cover the container while maintaining aspect ratio */
        }
    </style>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                            data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                            data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('images/logo-white.png') }}"
                                srcset="{{ asset('images/logo-white.png') }} 2x" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('images/logo-white.png') }}"
                                srcset="{{ asset('images/logo-white.png') }} 2x" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">

                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Dashboards</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('consumers.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
                                        <span class="nk-menu-text">Users</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('billings.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-bitcoin-cash"></em></span>
                                        <span class="nk-menu-text"> Billing</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('settings.general') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                        <span class="nk-menu-text"> General Setting</span>
                                    </a>
                                </li><!-- .nk-menu-item -->
                                {{-- <li class="nk-menu-item">
                                    <a href="html/index-analytics.html" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                                        <span class="nk-menu-text">Pay Bills</span>
                                    </a>
                                </li><!-- .nk-menu-item --> --}}

                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                                        class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="./images/logo.png"
                                        srcset="{{ asset('images/logo-white.png') }} 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="./images/logo-bms.png"
                                        srcset="./images/logo-bms.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">

                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatars sm">
                                                    <img src="{{ asset('images/admin/' . Auth::user()->admin_image) }}"
                                                        alt="" srcset="">

                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">{{ ucwords(Auth::user()->designation) }}
                                                    </div>
                                                    <div class="user-name dropdown-indicator">
                                                        {{ ucwords(Auth::user()->display_name) ?? 'Display name' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatars">
                                                        <span>
                                                            <img src="{{ asset('images/admin/' . Auth::user()->admin_image) }}"
                                                                alt="" srcset="">
                                                        </span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span
                                                            class="lead-text">{{ ucwords(Auth::user()->name) }}</span>
                                                        <span class="sub-text">{{ Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <!-- <li><a href="html/user-profile-regular.html"><em
                                                                class="icon ni ni-user-alt"></em><span>View
                                                                Profile</span></a></li> -->
                                                     <li><a href="{{ route('settings.index') }}"><em
                                                                class="icon ni ni-setting-alt"></em><span>Account
                                                                Setting</span></a></li> 

                                                    <li><a class="dark-switch" href="#"><em
                                                                class="icon ni ni-moon"></em><span>Dark Mode</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->

                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
                <!-- content @e -->

            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/bundle.js?ver=3.2.3') }}"></script>
    <script src="{{ asset('assets/js/scripts.js?ver=3.2.3') }}"></script>
    <script src="{{ asset('assets/js/charts/gd-default.js?ver=3.2.3') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btns.js?ver=3.2.3') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
