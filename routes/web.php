<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect(route('/login'));
});
Route::get('coba', function () {
    return view('test');
});
Route::get('login', 'App\Http\Controllers\Auth\AuthController@index')->name('/login');
Route::post('singin', 'App\Http\Controllers\Auth\AuthController@doLogin')->name('/singin');

Route::group(['middleware' => ['app_auth']], static function () {
    Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('/dashboard');
    Route::get('logout', 'App\Http\Controllers\Auth\AuthController@logout')->name('/logout');

    #user
    Route::match(['get', 'post'], '/us/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'User/User');
    });

    #user mapping
    Route::match(['get', 'post'], '/ump/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'User/UserMapping');
    });

    #switch system
    Route::get('SwitchSystem/{ssId}', 'App\Http\Controllers\Auth\AuthController@doSwitch')->name('/doSwitchSystem');
    Route::match(['get', 'post'], '/ssy/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Setting/SwitchSystem');
    });

    #system setting
    Route::match(['get', 'post'], '/ss/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'System/SystemSetting');
    });
    #service
    Route::match(['get', 'post'], '/srv/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'System/Service/Service');
    });
    #systemType
    Route::match(['get', 'post'], '/sty/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'System/SystemType');
    });
    #systemService
    Route::match(['get', 'post'], '/ssr/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'System/Service/SystemService');
    });
    #contactPerson
    Route::match(['get', 'post'], '/cp/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Relation/ContactPerson');
    });
    #driver
    Route::match(['get', 'post'], '/dr/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Relation/Driver');
    });
    #asset
    Route::match(['get', 'post'], '/as/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Master/Asset');
    });
    #mobil
    Route::match(['get', 'post'], '/mb/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Master/Mobil');
    });
    #transaksi
    Route::match(['get', 'post'], '/tr/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Transaction/Transaksi');
    });
    #transaksi mobil
    Route::match(['get', 'post'], '/trm/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Transaction/Transportasi/TransaksiMobil');
    });
    #sepeda motor
    Route::match(['get', 'post'], '/sp/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Master/SepedaMotor');
    });
    #transaksi sepeda motor
    Route::match(['get', 'post'], '/tsm/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Transaction/Transportasi/TransaksiSepedaMotor');
    });
    #system
    Route::match(['get', 'post'], '/system/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Setting/System');
    });
    #system
    Route::match(['get', 'post'], '/mn/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'System/Menu');
    });

    #system
    Route::match(['get', 'post'], '/rb/{pc?}', static function ($pc = 'listing') {
        $control = new PageController();
        return $control->doControl($pc, 'Master/Perpustakaan/Rak');
    });
});
