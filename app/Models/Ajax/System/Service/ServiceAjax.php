<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\System\Service;

use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\System\Service\ServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System\Service
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class ServiceAjax extends AbstractBaseAjaxModel
{
    /**
     * Function to load the data for single select for SystemType
     *
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(string $group=''): array
    {
        $wheres = [];
        $wheres[] = '(srv.srv_deleted_on IS NULL)';
        $wheres[] = "(srv.srv_active = 'Y')";

        return ServiceDao::loadData($wheres);
    }
}
