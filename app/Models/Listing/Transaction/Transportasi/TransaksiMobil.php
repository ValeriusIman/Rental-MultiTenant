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
use App\Models\Dao\Transaction\Transportasi\TransaksiMobilDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Listing\Transaction
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiMobil extends AbstractListingModel
{

    /**
     * Transaksi constructor.
     */
    public function __construct()
    {
        parent::__construct('trm', 'transaksiMobil');
        $this->Table->setTitle(Trans::getWord('transaksiMobil'));
    }

    /**
     * Abstract function to load result table.
     *
     * @return void
     */
    public function loadResultTable(): void
    {
        $this->Table->setHeader([
            'tr_number' => Trans::getWord('number'),
            'tr_eta_date' => Trans::getWord('etaDate'),
            'tr_eta_time' => Trans::getWord('etaTime'),
            'tr_ata_date' => Trans::getWord('ataDate'),
            'tr_status' => Trans::getWord('status')
        ]);
        $this->Table->setRows($this->doPrepareData($this->loadData()));
        $this->Table->setEnableButtonEdit(false);
        $this->Table->setEnableButtonView('trm_tr_id');
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
            'tr.tr_id DESC'
        ];
        return TransaksiMobilDao::loadData($this->getWhereCondition(), $orderBys);
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
        $wheres[] = '(tr.tr_deleted_on IS NULL)';
        $wheres[] = SqlHelper::generateNumericCondition('tr_ss_id', $this->User->getSsId());
        return $wheres;
    }
}
