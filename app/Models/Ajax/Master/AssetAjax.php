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
use App\Frame\Mvc\AbstractBaseModel;
use App\Models\Dao\Master\AssetDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Ajax\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class AssetAjax extends AbstractBaseModel
{

    /**
     * Function to load the data for single select for AssetAjax
     * @param int $ssId
     * @param string $group
     * @return array
     */
    public static function loadSingleSelectData(int $ssId = null, string $group = null): array
    {
        $wheres = [];
        $wheres[] = '(ass.as_deleted_on IS NULL)';
        $wheres[] = "(ass.as_active = 'Y')";
//        $wheres[] = "(mb.mb_as_id IS NULL)";
        $wheres[] = SqlHelper::generateLikeCondition('srv.srv_code', $group);
        $wheres[] = SqlHelper::generateNumericCondition('ass.as_ss_id',$ssId);


        return AssetDao::loadData($wheres);
    }

}
