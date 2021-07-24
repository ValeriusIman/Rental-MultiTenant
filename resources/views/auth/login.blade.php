@extends('auth.main_login')
@section('title','Login')
@section('content')

    <!-- /.login-logo -->
    <div class="login-box">
        {{--        <div class="text-center">--}}
        {{--            <img src="<?= base_url() . 'assets/img/logo.png' ?>" class="rounded" alt="logo" width="200">--}}
        {{--        </div>--}}
        {{--        </p>--}}
        <div class="login-logo" style="font-size: 29px;">
            MULTI MUTIARA <b>RENTAL</b>
        </div>
        <div class="card">
            <div class="card-header">
                <div align="center">
                    LogIn untuk memulai sesi Anda
                </div>
            </div>
            <div class="card-body login-card-body">

                <form id="form-registration" method="POST" action="{{url('singin')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="userName" id="userName" class="form-control" placeholder="Username"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button id="btn-login" type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection

