<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\Transaction;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\Buttons\HyperLink;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Dao\System\Service\ServiceDao;
use App\Models\Dao\Transaction\TransaksiDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Transaction
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Transaksi extends AbstractFormModel
{
    /**
     * Transaksi constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('tr', 'tr_id');
        $this->setParameters($parameters);
        $this->setTitle('transaksi');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $noTransaksi = 'TR/MB/' . date('Ymd/H:i:s');
        $service = ServiceDao::loadIdByCode('mobil');
        $colVal = [
            'tr_us_id' => $this->User->getId(),
            'tr_ss_id' => $this->User->getSsId(),
            'tr_srv_id' => $service['srv_id'],
            'tr_number' => $noTransaksi,
            'tr_name_customer' => $this->getStringParameter('tr_name_customer'),
            'tr_eta_date' => $this->getStringParameter('tr_eta_date'),
            'tr_eta_time' => $this->getStringParameter('tr_eta_time'),
            'tr_ata_date' => $this->getStringParameter('tr_ata_date'),
            'tr_jaminan_id' => $this->getIntParameter('tr_jaminan_id'),
        ];

        $trDao = new TransaksiDao();
        $trDao->doInsertTransaction($colVal);
        return $trDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        # TODO: Set update colVal data.
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return TransaksiDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general', $this->generalField());
        if ($this->isUpdate()) {
            $this->loadButton('mobil', $this->loadButtonTransaksi());
        }
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('tr_name_customer'),
            $this->Validation->checkRequire('tr_jaminan_id'),
            $this->Validation->checkRequire('tr_ata_date'),
            $this->Validation->checkRequire('tr_eta_date'),
            $this->Validation->checkRequire('tr_eta_time'),
            $this->Validation->checkRequire('trm_as_code'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('trPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 12, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 12, 12);
        $jaminan = $this->Field->getSelectData('sty', 'tr_jaminan_id', $this->getIntParameter('tr_jaminan_id'));
        $jaminan->setShowData(SystemTypeAjax::loadSingleSelectData('jaminan'), 'sty_name');


        $etaDate = $this->Field->getCalender('tr_eta_date', $this->getStringParameter('tr_eta_date'));
        $etaDate->enableStartDateNow();

        $ataDate = $this->Field->getCalender('tr_ata_date', $this->getStringParameter('tr_ata_date'));
        $ataDate->enableStartDateNow();

        $etaTime = $this->Field->getTime('tr_eta_time', $this->getStringParameter('tr_eta_time'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('customer'), $this->Field->getText('tr_name_customer', $this->getStringParameter('tr_name_customer')), true),
            $field->addField(Trans::getWord('jaminan'), $jaminan, true),
            $field->addField(Trans::getWord('etaDate'), $etaDate, true),
            $field->addField(Trans::getWord('etaTime'), $etaTime, true),
            $field->addField(Trans::getWord('ataDate'), $ataDate, true)
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * function to load table
     * @return void
     */
    public function loadTable(): void
    {

    }

    /**
     * load button transaksi mobil
     * @return string
     */
    private function loadButtonTransaksi(): string
    {
        $url = url('/trm/detail?tr_id=' . $this->getDetailReferenceValue());
        $button = new HyperLink('btnTrMobil',Trans::getWord('mobil'), $url);
        $button->setIcon('fa-car');
        $button->btnWarning();
        return $button;
    }
}
