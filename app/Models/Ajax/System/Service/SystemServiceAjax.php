<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\System\Service;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\System\Service\SystemServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemServiceAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for SystemService
     * @return array
     */
    public static function loadSingleSelectData(): array
    {
        $wheres = [];
        $wheres[] = '(ssr.ssr_deleted_on IS NULL)';
        $wheres[] = "(ssr.ssr_active = 'Y')";

        return SystemServiceDao::loadData($wheres);
    }
}
