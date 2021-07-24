<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Master;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Master\AssetDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Asset extends AbstractListingModel
{
    /**
     * Asset constructor.
     */
    public function __construct()
    {
        parent::__construct('as', 'asset');
        $this->Table->setTitle(Trans::getWord('asset'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'as_srv_name' => Trans::getWord('service'),
            'as_code' => Trans::getWord('code'),
            'as_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'as_id');
        $this->Table->addColumnAttribute('as_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'ass.as_id DESC'
        ];
        return AssetDao::loadData($this->getWhereCondition(),$orderBys);
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
        $wheres[] = SqlHelper::generateNumericCondition('ass.as_ss_id', $this->User->getSsId());
        $wheres[] = '(ass.as_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
