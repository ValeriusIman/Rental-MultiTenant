<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Listing\Transaction\Transportasi;

use App\Frame\Formatter\SqlHelper;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\Labels\Label;
use App\Frame\Mvc\AbstractListingModel;
use App\Models\Dao\Transaction\Transportasi\TransaksiSepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Transaction\Transportasi
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotor extends AbstractListingModel
{
    /**
     * TransaksiSepedaMotor constructor.
     */
    public function __construct()
    {
        parent::__construct('tsm', 'transaksiSepedaMotor');
        $this->Table->setTitle(Trans::getWord('transaksiSepedaMotor'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'tsm_tr_number' => Trans::getWord('number'),
            'tr_eta_date' => Trans::getWord('etaDate'),
            'tr_eta_time' => Trans::getWord('etaTime'),
            'tr_ata_date' => Trans::getWord('ataDate'),
            'tr_status' => Trans::getWord('status')
        ]);
        $this->Table->setRows($this->doPrepareData($this->loadData()));
        $this->Table->setEnableButtonEdit(false);
        $this->Table->setEnableButtonView('tsm_tr_id');
        $this->Table->addColumnAttribute('tr_status', 'style', 'text-align: center');

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
            if (empty($row['tr_finish_on']) === false) {
                $row['tr_status'] = new Label(Trans::getWord('kembali'), 'success');
            } else {
                $row['tr_status'] = new Label(Trans::getWord('digunakan'), 'warning');
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
            'tsm.tsm_id DESC'
        ];
        return TransaksiSepedaMotorDao::loadData($this->getWhereCondition(), $orderBys);
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
        $wheres[] = '(tsm.tsm_deleted_on IS NULL)';
        $wheres[] = SqlHelper::generateNumericCondition('tr_ss_id', $this->User->getSsId());
        return $wheres;
    }
}
