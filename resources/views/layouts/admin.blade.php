<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pro School | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    @yield('styles')

</head>


<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown show">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                      <span style="margin-top: 0px;">Admin</span>
                                  <img id="profile_img" class="brand-image img-circle" width="35" height="35" src="{{ asset('storage/avatars/avatar1.png') }}">
                              </a>
                    <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                      <a href="{{ route('settings.index') }}" class="dropdown-item">
                        <i class="fas fa-cog mr-2 text-blue"></i> Settings
                      </a>
                      <a href="{{ route('admin.logout') }}" class="dropdown-item">
                        <i class="fas fa-power-off mr-2 text-red"></i> Logout
                      </a>
                    </div>
                  </li>
            </ul>
        </nav>


        @include('layouts.partials.sidebar')

        @yield('content')

        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>


        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Developed By <a href="https://matinsoftech.com">Matinsoftech</a>
            </div>
        </footer>
    </div>



    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    @yield('scripts')
</body>

</html>