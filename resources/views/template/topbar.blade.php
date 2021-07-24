<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
            <span class="hidden-xs">{{$session['us_name']}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="{{url('/ssy')}}" class="dropdown-item">
                <i class="fas fa-fw fa-key mr-2"></i>Switch System
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{route('/logout')}}" class="dropdown-item">
                <i class="fas fa-fw fa-power-off mr-2"></i>Keluar
            </a>
        </div>
    </li>
</ul>
