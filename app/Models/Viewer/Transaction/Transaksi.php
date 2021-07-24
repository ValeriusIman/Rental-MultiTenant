<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Viewer\Transaction;

use App\Frame\Formatter\NumberFormatter;
use App\Frame\Formatter\StringFormatter;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractViewerModel;
use App\Models\Dao\Transaction\Transportasi\TransaksiMobilDao;
use App\Models\Dao\Transaction\TransaksiDao;
use App\Models\Dao\Transaction\Transportasi\TransaksiSepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Viewer\TransactionMobil
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Transaksi extends AbstractViewerModel
{

    /**
     * TransaksiMobil constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('tr', 'tr_id');
        $this->setParameters($parameters);
        $this->setTitle(Trans::getWord('transaksiMobil'));
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
//        dd(TransaksiDao::getByReference($this->getDetailReferenceValue()));
        return TransaksiDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $data = TransaksiDao::getByReference($this->getDetailReferenceValue());
        $this->setLabel('test');
        if ($data['tr_srv_code'] === 'mobil') {
            $this->setView('general', $this->getMobilPortlet());
        }
        if ($data['tr_srv_code'] === 'sepedamotor') {
            $this->setView('sepedaMotor', $this->getSepedaMotorPortlet());
        }
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        # TODO: Set the validation rule here.
    }

    /**
     * function to viewer general
     * @return Portlet
     */
    private function getMobilPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('viewPtl', Trans::getWord('general'));
        $mobil = TransaksiMobilDao::getByTransaksiId($this->getDetailReferenceValue());
        $number = new NumberFormatter();
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('asset'),
                'value' => $mobil['trm_as_id']
            ],
            [
                'label' => Trans::getWord('driver'),
                'value' => $this->getIntParameter('trm_dr_id')
            ],
            [
                'label' => Trans::getWord('harga'),
                'value' => 'Rp. ' . $number->doFormatFloat($this->getIntParameter('trm_price'), true)
            ],
            [
                'label' => Trans::getWord('driverFee'),
                'value' => 'Rp. ' . $number->doFormatFloat($this->getIntParameter('trm_driver_fee'), true)
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to viewer general
     * @return Portlet
     */
    private function getSepedaMotorPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('viewPtl', Trans::getWord('general'));
        $sepedaMotor = TransaksiSepedaMotorDao::getByTransaksiId($this->getDetailReferenceValue());
        $number = new NumberFormatter();
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('asset'),
                'value' => $sepedaMotor['tsm_as_id']
            ],
            [
                'label' => Trans::getWord('harga'),
                'value' => 'Rp. ' . $number->doFormatFloat($this->getIntParameter('tsm_harga'), true)
            ]
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }
}
