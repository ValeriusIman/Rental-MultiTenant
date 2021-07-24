<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\Transaction\Transportasi;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\Master\MobilAjax;
use App\Models\Ajax\Relation\DriverAjax;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Dao\Master\MobilDao;
use App\Models\Dao\Relation\DriverDao;
use App\Models\Dao\System\Service\ServiceDao;
use App\Models\Dao\System\SystemTypeDao;
use App\Models\Dao\Transaction\Transportasi\TransaksiMobilDao;
use App\Models\Dao\Transaction\TransaksiDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Transaction\Mobil
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiMobil extends AbstractFormModel
{
    /**
     * TransaksiMobil constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('trm', 'trm_id');
        $this->setParameters($parameters);
        $this->setTitle('transaksiMobil');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        #Transaksi
        $noTransaksi = 'TR/' . strtoupper($this->User->getNameSpace()) . '/MB/' . date('Ymd/H:i:s');
        $service = ServiceDao::loadIdByCode('mobil');
        $colTrVal = [
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
        $trDao->doInsertTransaction($colTrVal);
        $lastId = $trDao->getLastInsertId();

        #Transaksi Mobil
        $mobil = MobilDao::getPriceByAssetId($this->getIntParameter('mb_as_id'));
        $colTrmVal = [
            'trm_as_id' => $this->getIntParameter('mb_as_id'),
            'trm_tr_id' => $lastId,
            'trm_dr_id' => $this->getIntParameter('trm_dr_id'),
            'trm_price' => $mobil['mb_price'],
            'trm_driver_fee' => $this->getIntParameter('trm_driver_fee')
        ];
        $trmDao = new TransaksiMobilDao();
        $trmDao->doInsertTransaction($colTrmVal);

        #Driver
        $colDrVal = [
            'dr_status' => 'N',
        ];
        $drDao = new DriverDao();
        $drDao->doUpdateTransaction($this->getIntParameter('trm_dr_id'), $colDrVal);

        #Mobil
        $sty = SystemTypeDao::getByName('Not Available');
        $colMbVal = [
            'mb_status_id' => $sty['sty_id']
        ];
        $mbDao = new MobilDao();
        $mbDao->doUpdateTransaction($mobil['mb_id'], $colMbVal);

        return $trmDao->getLastInsertId();
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
        return TransaksiMobilDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('transaction', $this->getTransactionField());
        $this->setView('asset', $this->generalField());

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
            $this->Validation->checkRequire('tr_eta_date'),
            $this->Validation->checkRequire('tr_eta_time'),
            $this->Validation->checkRequire('trm_as_code'),
            $this->Validation->checkNumber('trm_driver_fee', 4),
        ]);
    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('mbPtl', Trans::getWord('mobil'));
        $portlet->setGridDimension(6, 6, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 6, 12);

        $asset = $this->Field->getSingleSelect('mb_as', 'trm_as_code');
        $asset->setShowData(MobilAjax::loadSingleSelectData(), 'mb_as_code');
        $asset->setHiddenField('mb_as_id', $this->getIntParameter('mb_as_id'));
        $asset->setChildren('trm_price', 'mb_price');

        $driver = $this->Field->getSingleSelect('dr', 'trm_dr_name');
        $driver->setShowData(DriverAjax::loadSingleSelectData(), 'dr_name');
        $driver->setHiddenField('trm_dr_id', $this->getIntParameter('trm_dr_id'));

        $price = $this->Field->getText('trm_price', $this->getIntParameter('trm_price'));
        $price->setReadOnly();

        $driverFee = $this->Field->getText('trm_driver_fee', $this->getIntParameter('trm_driver_fee'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('asset'), $asset, true),
            $field->addField(Trans::getWord('harga').'/Hari', $price),
            $field->addField(Trans::getWord('driver'), $driver),
            $field->addField(Trans::getWord('driverFee'), $driverFee),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }


    /**
     * abstract function to field
     * @return Portlet
     */
    protected function getTransactionField(): Portlet
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
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
