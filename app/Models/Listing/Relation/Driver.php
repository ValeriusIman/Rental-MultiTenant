<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Relation;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Relation\DriverDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Relation
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Driver extends AbstractListingModel
{
    /**
     * Driver constructor.
     */
    public function __construct()
    {
        parent::__construct('dr', 'driver');
        $this->Table->setTitle(Trans::getWord('driver'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'dr_name' => Trans::getWord('name'),
            'dr_phone' => Trans::getWord('phone'),
            'dr_address' => Trans::getWord('address'),
            'dr_status' => Trans::getWord('status'),
            'dr_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'dr_id');
        $this->Table->addColumnAttribute('dr_active', 'style', 'text-align: center');
        $this->Table->addColumnAttribute('dr_status', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'dr.dr_id DESC'
        ];
       return DriverDao::loadData($this->getWhereCondition(),$orderBys);
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
        $wheres[] = SqlHelper::generateNumericCondition('dr.dr_ss_id', $this->User->getSsId());
        $wheres[] = '(dr.dr_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
