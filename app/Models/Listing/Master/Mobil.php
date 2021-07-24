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
use App\Frame\Gui\Labels\Label;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Master\MobilDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Mobil extends AbstractListingModel
{
    /**
     * Mobil constructor.
     */
    public function __construct()
    {
        parent::__construct('mb', 'mobil');
        $this->Table->setTitle(Trans::getWord('mobil'));
    }


    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'as_code' => Trans::getWord('asset'),
            'mb_brand' => Trans::getWord('brand'),
            'mb_variant' => Trans::getWord('variant'),
            'mb_sty_type' => Trans::getWord('type'),
            'mb_status' => Trans::getWord('status'),
            'mb_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows($this->doPrepareData($this->loadData()));
        $this->Table->setEnableButtonView('mb_id');
        $this->Table->setEnableButtonEdit(true,'mb_id');
        $this->Table->addColumnAttribute('mb_status', 'style', 'text-align: center');
        $this->Table->addColumnAttribute('mb_active', 'style', 'text-align: center');

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
            if ($row['mb_status'] === 'Not Available') {
                $row['mb_status'] = new Label(Trans::getWord('notAvailable'), 'danger');
            }
            if ($row['mb_status'] === 'Available') {
                $row['mb_status'] = new Label(Trans::getWord('available'), 'success');
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
            'mb.mb_id DESC'
        ];
        return MobilDao::loadData($this->getWhereCondition(),$orderBys);
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
        $wheres[] = '(mb.mb_deleted_on IS NULL)';
        $wheres[] = SqlHelper::generateNumericCondition('ass.as_ss_id',$this->User->getSsId());

        return $wheres;
    }
}
