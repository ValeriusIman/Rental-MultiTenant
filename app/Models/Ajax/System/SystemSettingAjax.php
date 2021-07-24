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
use App\Models\Dao\System\SystemSettingDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemSettingAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for SystemSetting
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(string $group = ''): array
    {
        $wheres = [];
        $wheres[] = '(ss.ss_deleted_on IS NULL)';
        $wheres[] = "(ss.ss_active = 'Y')";
        return SystemSettingDao::loadData($wheres);
    }
}
