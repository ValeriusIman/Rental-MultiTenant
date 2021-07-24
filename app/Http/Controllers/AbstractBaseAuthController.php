<?php

namespace App\Http\Controllers;

use App\Frame\System\SystemSettings;
use App\Models\Dao\User\UserMappingDao;

class AbstractBaseAuthController extends Controller
{
    /**
     * Function to check is the user already login or not.
     *
     * @return boolean
     */
    protected function isLogin(): bool
    {
        return (session('user') !== null);
    }

    /**
     * Function to generate the user token.
     *
     * @param array $user To set the user id.
     *
     * @return void
     */
    protected function setSession(array $user): void
    {
        # Set remember user.
        if (empty($user) === false) {
            if ($user['us_system'] === 'N') {
                $user['systems'] = UserMappingDao::loadAllUserMappingData($user['us_id'], $user['ss_id']);
            } else {
                $user['systems'] = UserMappingDao::loadAllUserMappingDataForSystem($user['ss_id']);
            }
//            dd($user);
            $settings = new SystemSettings();
            $settings->registerSystemSetting($user);
        } else {
            echo 'Failed';
        }
    }

    /**
     * Function to generate the user token.
     *
     * @return void
     */
    protected function removeSession(): void
    {
        session()->flush();
        session()->regenerate();
    }
}
