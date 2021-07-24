<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{url('/dashboard')}}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Relation
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($menu as $mn)
                        @if($mn['mn_sub_menu'] === 'Relation')
                            @if(empty($mn['ss_id'])===true)
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                            @if($mn['ss_id'] === $session['ss_id'])
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Master
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($menu as $mn)
                        @if($mn['mn_sub_menu'] === 'Master')
                            @if($mn['ss_id'] === $session['ss_id'])
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                            @if(empty($mn['ss_id'])===true)
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-header">OPERATION</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-server"></i>
                    <p>
                        Transportasi
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($menu as $mn)
                        @if($mn['mn_sub_menu'] === 'Transportasi')
                            @if($mn['ss_id'] === $session['ss_id'])
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                            @if(empty($mn['ss_id'])===true)
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="nav-header">SETTINGS</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Setting
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($menu as $mn)
                        @if($mn['mn_sub_menu'] === 'Setting')
                            <li class="nav-item">
                                <a href="{{url('/' . $mn['mn_route'].'/detail?ss_id=').$session['ss_id']}}"
                                   class="nav-link">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                    <p>{{$mn['mn_name']}}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @if($session['ss_system'] === 'Y')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p>
                            System
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($menu as $mn)
                            @if($mn['mn_sub_menu'] === 'System')
                                <li class="nav-item">
                                    <a href="{{url('/' . $mn['mn_route'])}}"
                                       class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                        <p>{{$mn['mn_name']}}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Service
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach($menu as $mn)
                                    @if($mn['mn_sub_menu'] === 'System - Service')
                                        <li class="nav-item">
                                            <a href="{{url('/' . $mn['mn_route'])}}"
                                               class="nav-link">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="{!! $mn['mn_icon'] !!} nav-icon"></i>
                                                <p>{{$mn['mn_name']}}</p>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
