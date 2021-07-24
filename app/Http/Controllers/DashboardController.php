<?php

namespace App\Http\Controllers;


use App\Frame\System\Session\UserSession;
use App\Models\Dao\System\SystemSettingDao;

class DashboardController extends Controller
{
    /**
     * function for dashboard page
     *
     * @return mixed
     */
    public function index()
    {
        $user = new UserSession();
        $menu = SystemSettingDao::loadMenu($user->getSsId());
        $data = [
            'session' => session('user'),
            'menu' => $menu
        ];
        return view('dashboard', $data);
    }

}
