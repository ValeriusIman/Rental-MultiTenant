<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Setting;

use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\User\UserMappingDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Setting
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SwitchSystem extends AbstractListingModel
{
    /**
     * SwitchSystem constructor.
     */
    public function __construct()
    {
        parent::__construct('ump', 'switchSystem');
        $this->Table->setTitle(Trans::getWord('switchSystem'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'ss_relation' => Trans::getWord('name')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(false);
        $this->Table->setEnableButtonSwitch();
    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        return UserMappingDao::loadData($this->getWhereCondition());
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
        $wheres[] = '(ump.ump_ss_id <> ' . $this->User->getSsId() . ')';
        $wheres[] = '(ump.ump_us_id = ' . $this->User->getId() . ')';
        $wheres[] = '(ump.ump_deleted_on IS NULL)';
        $wheres[] = "(ss.ss_active = 'Y')";
        $wheres[] = '(ss.ss_deleted_on IS NULL)';
        return $wheres;
    }
}
