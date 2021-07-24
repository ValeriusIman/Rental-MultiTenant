<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Master\Perpustakaan;

use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Master\Perpustakaan\RakDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Master\Perpustakaan
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Rak extends AbstractListingModel
{
    /**
     * Rak constructor.
     */
    public function __construct()
    {
        parent::__construct('rb', 'rak');
        $this->Table->setTitle(Trans::getWord('rak'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'rb_number' => Trans::getWord('number'),
            'rb_kategori' => Trans::getWord('kategori')
        ]);
        $this->Table->setRows($this->loadData());
    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'rb.rb_id DESC'
        ];
        return RakDao::loadData();
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
        $wheres[] = '(rb.rb_deleted_on IS NULL)';
        return $wheres;
    }
}
