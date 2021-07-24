<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\User;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\User\UserDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class UserAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for UserAjax
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(string $group = null): array
    {
        $wheres = [];
        $wheres[] = '(us.us_deleted_on IS NULL)';
        $wheres[] = "(us.us_active = 'Y')";

        return UserDao::loadData($wheres);
    }
}
