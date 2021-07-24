<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\System;

/**
 *
 *
 * @package    app
 * @subpackage Frame\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemSettings
{
    /**
     * Property to store the user data.
     *
     * @var array
     */
    private $User = [];

    /**
     * Function to load the relation settings.
     *
     * @param array $user to Store the user data.
     *
     * @return void
     */
    public function registerSystemSetting(array $user): void
    {
        $this->User = $user;
        if (session()->exists('user') === false) {
            session()->put('user', $user);
        }

    }
}
