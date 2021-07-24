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
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\Master\Transportasi\SepedaMotorAjax;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Dao\Master\SepedaMotorDao;
use App\Models\Dao\System\Service\ServiceDao;
use App\Models\Dao\System\SystemTypeDao;
use App\Models\Dao\Transaction\TransaksiDao;
use App\Models\Dao\Transaction\Transportasi\TransaksiSepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Transaction\Transportasi
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotor extends AbstractFormModel
{
    /**
     * TransaksiSepedaMotor constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('tsm', 'tsm_id');
        $this->setParameters($parameters);
        $this->setTitle('transaksiSepedaMotor');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        #transaksi
        $noTransaksi = 'TR/' . strtoupper($this->User->getNameSpace()) . '/SM/' . date('Ymd/H:i:s');
        $service = ServiceDao::loadIdByCode('sepedamotor');
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
        $trId = $trDao->getLastInsertId();

        #transaksi sepeda motor
        $sepedaMotor = SepedaMotorDao::getPriceByAssetId($this->getIntParameter('sp_as_id'));
        $colTsmVal = [
            'tsm_as_id' => $this->getIntParameter('sp_as_id'),
            'tsm_tr_id' => $trId,
            'tsm_harga' => $sepedaMotor['sp_harga']
        ];
        $tsmDao = new TransaksiSepedaMotorDao();
        $tsmDao->doInsertTransaction($colTsmVal);

        #sepeda motor
        $sty = SystemTypeDao::getByName('Not Available');
        $colSpVal = [
            'sp_status_id' => $sty['sty_id']
        ];
        $spDao = new SepedaMotorDao();
        $spDao->doUpdateTransaction($sepedaMotor['sp_id'],$colSpVal);

        return $tsmDao->getLastInsertId();
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
        return TransaksiSepedaMotorDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general', $this->generalField());
        $this->setView('asset', $this->assetField());
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
    protected function generalField(): Portlet
    {
        $portlet = new Portlet('tsmPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 6, 12);

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

    /**
     * abstract function to field
     * @return Portlet
     */
    public function assetField(): Portlet
    {
        $portlet = new Portlet('tsmPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 6, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 12, 12);

        $asset = $this->Field->getSingleSelect('sp_as', 'trm_as_code');
        $asset->setShowData(SepedaMotorAjax::loadSingleSelectData(), 'sp_as_code');
        $asset->setHiddenField('sp_as_id', $this->getIntParameter('sp_as_id'));
        $asset->setChildren('sp_harga', 'sp_harga');

        $price = $this->Field->getText('sp_harga', $this->getIntParameter('sp_harga'));
        $price->setReadOnly();

        $row = $this->addRow([
            $field->addField(Trans::getWord('asset'), $asset, true),
            $field->addField(Trans::getWord('harga') . '/Hari', $price),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
