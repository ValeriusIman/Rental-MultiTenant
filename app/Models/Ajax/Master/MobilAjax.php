<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Ajax\Master;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Mvc\AbstractBaseAjaxModel;
use App\Models\Dao\Master\MobilDao;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class MobilAjax extends AbstractBaseAjaxModel
{

    /**
     * Function to load the data for single select for Mobil
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
        $wheres[] = '(mb.mb_deleted_on IS NULL)';
        $wheres[] = "(mb.mb_active = 'Y')";
        $wheres[] = "(mb.mb_status_id = " . $result[0]->sty_id . ")";

        return MobilDao::loadData($wheres);
    }
}
