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
use App\Models\Dao\System\Service\SystemServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\System\Service
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemService extends AbstractListingModel
{
    /**
     * SystemService constructor.
     */
    public function __construct()
    {
        parent::__construct('ssr', 'systemService');
        $this->Table->setTitle(Trans::getWord('systemService'));
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'ssr_ss_relation' => Trans::getWord('systemSetting'),
            'ssr_srv_code' => Trans::getWord('service'),
            'ssr_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'ssr_id');
        $this->Table->addColumnAttribute('ssr_active', 'style', 'text-align: center');

    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'ssr.ssr_id DESC'
        ];
        return SystemServiceDao::loadData($this->getWhereCondition(),$orderBys);
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
        $wheres[] = '(ssr.ssr_deleted_on IS NULL)';
        # return the list where condition.
        return $wheres;
    }
}
