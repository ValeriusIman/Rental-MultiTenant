<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\Relation;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\Relation\DriverDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class DriverAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for Driver
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(string $group = null): array
    {
        $wheres = [];
        $wheres[] = '(dr.dr_deleted_on IS NULL)';
        $wheres[] = "(dr.dr_active = 'Y')";
        $wheres[] = "(dr.dr_status = 'Y')";

        return DriverDao::loadData($wheres);
    }
}
