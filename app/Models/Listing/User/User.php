<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\User;

use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\User\UserDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\User
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class User extends AbstractListingModel
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct('us', 'user');
        $this->Table->setTitle(Trans::getWord('user'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'us_name' => Trans::getWord('name'),
            'us_username' => Trans::getWord('email'),
            'us_system' => Trans::getWord('system'),
            'us_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->loadData());
        $this->Table->setEnableButtonEdit(true,'us_id');
        $this->Table->addColumnAttribute('us_system','style','text-align:center');
        $this->Table->addColumnAttribute('us_active','style','text-align:center');
    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        return UserDao::loadData($this->getWhereCondition());
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
        $wheres[] = '(us.us_deleted_on IS NULL)';
        return $wheres;
    }
}
