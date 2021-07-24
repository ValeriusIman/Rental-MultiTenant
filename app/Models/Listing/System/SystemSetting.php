<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\System;

use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\System\SystemSettingDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemSetting extends AbstractListingModel
{

    /**
     * SystemSetting constructor.
     */
    public function __construct()
    {
        parent::__construct('ss', 'systemSetting');
        $this->Table->setTitle(Trans::getWord('systemSetting'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'ss_relation' => Trans::getWord('relation'),
            'ss_name_space' => Trans::getWord('nameSpace'),
            'ss_decimal_number' => Trans::getWord('decimalNumber'),
            'ss_decimal_separator' => Trans::getWord('decimalSeparator'),
            'ss_system' => Trans::getWord('system'),
            'ss_active' => Trans::getWord('active'),
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'ss_id');
        $this->Table->addColumnAttribute('ss_active', 'style', 'text-align: center');
        $this->Table->addColumnAttribute('ss_system', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'ss.ss_id DESC'
        ];
        return SystemSettingDao::loadData($this->getWhereCondition(),$orderBys);
    }


    /**
     * Function to get the where condition.
     *
     * @return array
     */
    private function getWhereCondition(): array
    {
        # Set where conditions
        $wheres = [];
        $wheres[] = '(ss.ss_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
