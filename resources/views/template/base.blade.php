<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$session['ss_name_space']}} | @yield('title','title')</title>

    @include('template.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        @include('template.topbar')
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{$session['ss_relation']}}</span>
        </a>

        @include('template.sidebar')
    </aside>

    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('template.footer')

    <aside class="control-sidebar control-sidebar-dark">

    </aside>
</div>

@include('template.script')
</body>

</html>
