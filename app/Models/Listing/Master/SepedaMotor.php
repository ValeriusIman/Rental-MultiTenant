<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Master;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\Labels\Label;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Master\SepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SepedaMotor extends AbstractListingModel
{
    /**
     * SepedaMotor constructor.
     */
    public function __construct()
    {
        parent::__construct('sp', 'sepedaMotor');
        $this->Table->setTitle(Trans::getWord('sepedaMotor'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'sp_as_code' => Trans::getWord('asset'),
            'sp_brand' => Trans::getWord('brand'),
            'sp_variant' => Trans::getWord('variant'),
            'sp_type_name' => Trans::getWord('type'),
            'sp_status_name' => Trans::getWord('status'),
            'sp_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->doPrepareData($this->loadData()));
        $this->Table->addColumnAttribute('sp_status_name', 'style', 'text-align: center');
        $this->Table->addColumnAttribute('sp_active', 'style', 'text-align: center');
        $this->Table->setEnableButtonEdit(true,'sp_id');
        $this->Table->setEnableButtonView('sp_id');

    }

    /**
     * Function to do prepare data.
     *
     * @param array $data To store the data.
     *
     * @return array
     */
    private function doPrepareData(array $data): array
    {
        $results = [];

        foreach ($data as $row) {
            if ($row['sp_status_name'] === 'Not Available') {
                $row['sp_status_name'] = new Label(Trans::getWord('notAvailable'), 'danger');
            }
            if ($row['sp_status_name'] === 'Available') {
                $row['sp_status_name'] = new Label(Trans::getWord('available'), 'success');
            }
            $results[] = $row;
        }

        return $results;
    }

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    public function loadData(): array
    {
        $orderBys = [
            'sp.sp_id DESC'
        ];
        return SepedaMotorDao::loadData($this->getWhereCondition(), $orderBys);
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
        $wheres[] = '(sp.sp_deleted_on IS NULL)';
        return $wheres;
    }
}
