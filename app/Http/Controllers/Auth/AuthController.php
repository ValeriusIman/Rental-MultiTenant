<?php

namespace App\Http\Controllers\Auth;

use App\Frame\Exceptions\Message;
use App\Frame\Formatter\Trans;
use App\Frame\System\Session\UserSession;
use App\Frame\System\Validation;
use App\Http\Controllers\AbstractBaseAuthController;
use App\Models\Dao\User\UserDao;
use App\Models\Dao\User\UserMappingDao;
use Exception;

class AuthController extends AbstractBaseAuthController
{
    /**
     * function for the login page
     * @return mixed
     */
    public function index()
    {
        if ($this->isLogin() === true) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * function for the login process
     * @return mixed
     */
    public function doLogin()
    {
        $validator = new Validation();
        $validator->setInputs(request()->all());
        $validator->doValidation();
        try {
            $userDao = new UserDao();
            $user = $userDao->getLoginData(request('userName'), request('password'));
            unset($user['us_password']); //hapus array
            if (empty($user) === true) {
                Message::throwMessage(Trans::getWord('failed', 'message'));
            }
            if ($user['us_system'] === 'N') {
                $userSetting = UserMappingDao::loadUserMappingData($user['us_id']);
            } else {
                $userSetting = UserMappingDao::loadSystemMappingData();
            }
            if (empty($userSetting) === true) {
                Message::throwMessage(Trans::getWord('failed', 'message'));
            }
            $user = array_merge($user, $userSetting);
            $this->setSession($user);
            return redirect(route('/dashboard'));
        } catch (Exception $e) {
            return redirect(route('/login'));
        }
    }

    /**
     * function to delete session
     * @return mixed
     */
    public function logout()
    {
        session()->flush();
        session()->regenerate();

        return redirect(route('/login'));
    }

    /**
     * function to switch system settings
     * @param int $ssId store id of system settings
     * @return mixed
     */
    public function doSwitch(int $ssId)
    {
        try {
            $userSession = new UserSession();
            $user = UserDao::getByReference($userSession->getId());
            if (empty($user) === true) {
                Message::throwMessage(Trans::getWord('failed', 'message'));
            }
            if ($user['us_system'] === 'N') {
                $userSetting = UserMappingDao::loadUserMappingData($user['us_id'], $ssId);
            } else {
                $userSetting = UserMappingDao::loadSystemMappingData($ssId);
            }
            if (empty($userSetting) === true) {
                Message::throwMessage(Trans::getWord('pageNotFound', 'message'));
            }
            $us = array_merge($user, $userSetting);
            $this->removeSession();
            $this->setSession($us);

            return redirect('/dashboard');

        } catch (Exception $e) {
            return 'Page Not Found';
        }
    }
}
