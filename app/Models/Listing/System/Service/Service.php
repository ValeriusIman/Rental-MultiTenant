<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\System\Service;

use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\System\Service\ServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\System\Service
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Service extends AbstractListingModel
{

    /**
     * Service constructor.
     */
    public function __construct()
    {
        parent::__construct('srv', 'service');
        $this->Table->setTitle(Trans::getWord('service'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'srv_code' => Trans::getWord('code'),
            'srv_name' => Trans::getWord('service'),
            'srv_active' => Trans::getWord('active'),
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'srv_id');
        $this->Table->addColumnAttribute('srv_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'srv.srv_id DESC'
        ];
        return ServiceDao::loadData($this->getWhereCondition(),$orderBys);
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
        $wheres[] = '(srv.srv_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
