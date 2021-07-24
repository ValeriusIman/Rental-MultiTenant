<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\System;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\System\SystemTypeDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemTypeAjax extends AbstractBaseAjaxModel
{
    /**
     * Function to load the data for single select for SystemType
     *
     * @param $group
     * @return array
     */
    public static function loadSingleSelectData($group): array
    {
        $wheres = [];
        $wheres[] = '(sty.sty_deleted_on IS NULL)';
        $wheres[] = "(sty.sty_active = 'Y')";
        $wheres[] = SqlHelper::generateStringCondition('sty_group', $group);

        return SystemTypeDao::loadData($wheres);
    }

}
