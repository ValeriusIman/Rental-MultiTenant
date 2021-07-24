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
use App\Models\Dao\System\MenuDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Menu extends AbstractListingModel
{
    /**
     * Menu constructor.
     */
    public function __construct()
    {
        parent::__construct('mn', 'menu');
        $this->Table->setTitle(Trans::getWord('menu'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'mn_name' => Trans::getWord('title'),
            'mn_sub_menu' => Trans::getWord('subMenu'),
            'mn_route' => Trans::getWord('route'),
            'mn_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'mn_id');
        $this->Table->addColumnAttribute('mn_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'mn.mn_id DESC'
        ];
        return MenuDao::loadData($this->getWhereCondition(), $orderBys);
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
        # return the list where condition.
        $wheres[] = '(mn.mn_deleted_on IS NULL)';
        return $wheres;
    }
}
