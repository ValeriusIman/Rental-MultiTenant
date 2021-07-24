<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\Master\Transportasi;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\Master\SepedaMotorDao;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SepedaMotorAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for SepedaMotorAjax
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(string $group = null): array
    {
        $wheres = [];
        $styName[] = SqlHelper::generateLikeCondition('sty_name', 'Available');
        $strWhere = ' WHERE ' . implode(' AND ', $styName);
        $query = 'SELECT sty_id,sty_name FROM system_type' . $strWhere;
        $result = DB::select($query);
        $wheres[] = '(sp.sp_deleted_on IS NULL)';
        $wheres[] = "(sp.sp_active = 'Y')";
        $wheres[] = "(sp.sp_status_id = " . $result[0]->sty_id . ")";


        return SepedaMotorDao::loadData($wheres);
    }
}
