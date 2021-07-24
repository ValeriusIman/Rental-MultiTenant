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
use App\Models\Dao\System\SystemTypeDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemType extends AbstractListingModel
{
    /**
     * SystemType constructor.
     */
    public function __construct()
    {
        parent::__construct('sty', 'systemType');
        $this->Table->setTitle(Trans::getWord('systemType'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'sty_group' => Trans::getWord('group'),
            'sty_name' => Trans::getWord('name'),
            'sty_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'sty_id');
        $this->Table->addColumnAttribute('sty_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'sty.sty_id ASC'
        ];

        return SystemTypeDao::loadData($this->getWhereCondition(), $orderBys);
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
        $wheres[] = '(sty.sty_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
