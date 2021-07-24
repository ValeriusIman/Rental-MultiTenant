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
use App\Models\Dao\Relation\ContactPersonDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Relation
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class ContactPerson extends AbstractListingModel
{
    /**
     * ContactPerson constructor.
     */
    public function __construct()
    {
        parent::__construct('cp', 'contactPerson');
        $this->Table->setTitle(Trans::getWord('contactPerson'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'cp_name' => Trans::getWord('name'),
            'cp_phone' => Trans::getWord('phone'),
            'cp_address' => Trans::getWord('address'),
            'cp_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'cp_id');
        $this->Table->addColumnAttribute('cp_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'cp.cp_id DESC'
        ];
        return ContactPersonDao::loadData($this->getWhereCondition(), $orderBys);
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

        $wheres[] = SqlHelper::generateNumericCondition('cp.cp_ss_id', $this->User->getSsId());
        $wheres[] = '(cp.cp_deleted_on IS NULL)';

        # return the list where condition.
        return $wheres;
    }
}
