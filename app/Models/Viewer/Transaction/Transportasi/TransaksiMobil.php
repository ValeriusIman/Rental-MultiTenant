<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Viewer\Transaction\Transportasi;

use App\Frame\Formatter\NumberFormatter;
use App\Frame\Formatter\StringFormatter;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractViewerModel;
use App\Models\Dao\Master\MobilDao;
use App\Models\Dao\Relation\DriverDao;
use App\Models\Dao\System\SystemTypeDao;
use App\Models\Dao\Transaction\Transportasi\TransaksiMobilDao;
use App\Models\Dao\Transaction\TransaksiDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Viewer\Transaction\Mobil
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiMobil extends AbstractViewerModel
{
    /**
     * TransaksiMobil constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('trm', 'trm_tr_id');
        $this->setParameters($parameters);
        $this->setTitle(Trans::getWord('mobil'));
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        #Transaksi
        $colTrVal = [
            'tr_ata_time' => date('H:i:s'),
            'tr_finish_on' => date('Y-m-d H:i:s'),
            'tr_finish_by' => $this->User->getId(),
            'tr_bayar' => $this->getIntParameter('tr_bayar'),
            'tr_total' => $this->getIntParameter('tr_total'),
        ];
        $trDao = new TransaksiDao();
        $trDao->doUpdateTransaction($this->getIntParameter('tr_id'), $colTrVal);

        #Driver
        $colDrVal = [
            'dr_status' => 'Y'
        ];
        $drDao = new DriverDao();
        $drDao->doUpdateTransaction($this->getIntParameter('dr_id'), $colDrVal);

        #Mobil
        $sty = SystemTypeDao::getByName('Available');
        $mobil = MobilDao::getPriceByAssetId($this->getIntParameter('as_id'));
        $colMbVal = [
            'mb_status_id' => $sty['sty_id']
        ];
        $mbDao = new MobilDao();
        $mbDao->doUpdateTransaction($mobil['mb_id'], $colMbVal);

        #Transaksi Mobil
        $colTrmVal = [
            'trm_denda' => $this->getIntParameter('trm_denda')
        ];
        $trmDao = new TransaksiMobilDao();
        $trmDao->doUpdateTransaction($this->getDetailReferenceValue(), $colTrmVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
//        dd(TransaksiMobilDao::getByTransaksiId($this->getDetailReferenceValue()));
        return TransaksiMobilDao::getByTransaksiId($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $data = $this->loadData();
        $this->setLabel($this->getStringParameter('tr_number'));
        $this->setView('general', $this->getGeneralPortlet());
        if (!empty($data['tr_finish_on'])) {
            $this->setView('total', $this->getTotalPortlet());
        }
        if (empty($data['tr_finish_on'])) {
            $this->setView('cost', $this->getCostPortlet());
            $this->setView('pembayaran', $this->getFieldPortlet());
            $this->setEnableBtnFinish();
        }
        $this->setView('price', $this->getPricePortlet());
        $this->setParams('trm_tr_id');
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('tr_bayar', 5, 255, true),
            $this->Validation->checkNumber('trm_denda', 3)
        ]);
    }

    /**
     * function to viewer general
     * @return Portlet
     */
    private function getGeneralPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('GenPtl', Trans::getWord('general'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('nama'),
                'value' => $this->getStringParameter('tr_name_customer')
            ],
            [
                'label' => Trans::getWord('jaminan'),
                'value' => $this->getStringParameter('sty_name')
            ],
            [
                'label' => Trans::getWord('etaDate'),
                'value' => date('d F Y', strtotime($this->getStringParameter('tr_eta_date'))),
            ],
            [
                'label' => Trans::getWord('etaTime'),
                'value' => $this->getStringParameter('tr_eta_time')
            ],
            [
                'label' => Trans::getWord('ataDate'),
                'value' => date('d F Y', strtotime($this->getStringParameter('tr_ata_date')))
            ],
            [
                'label' => Trans::getWord('ataTime'),
                'value' => $this->getStringParameter('tr_ata_time')
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to viewer cost
     * @return Portlet
     */
    private function getCostPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('costPtl', Trans::getWord('detailPembayaran'));
        $number = new NumberFormatter();
        $mobil = $this->getHari() * $this->getIntParameter('trm_price');
        $driver = $this->getHari() * $this->getIntParameter('trm_driver_fee');
        $totalBiaya = $mobil + $driver;

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('biayaMobil'),
                'value' => 'Rp ' . $number->doFormatFloat($mobil, true)
            ],
            [
                'label' => Trans::getWord('biayaDriver'),
                'value' => 'Rp ' . $number->doFormatFloat($driver, true)
            ],
            [
                'label' => Trans::getWord('totalBiaya'),
                'value' => 'Rp ' . $number->doFormatFloat($totalBiaya, true)
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(4, 6);

        return $portlet;
    }

    private function getHari(): int
    {
        $data = $this->loadData();
        $tanggalPinjam = (abs(strtotime($data['tr_eta_date'])));
        $tanggalSekarang = (abs(strtotime(date('Y-m-d'))));
        return (abs($tanggalSekarang - $tanggalPinjam)) / (60 * 60 * 24);
    }

    /**
     * function to viewer cost
     * @return Portlet
     */
    private function getTotalPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('totalPtl', Trans::getWord('detailPembayaran'));
        $number = new NumberFormatter();

        $total = $this->getIntParameter('tr_total') + $this->getIntParameter('trm_denda', '0');

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('biayaMobil'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('trm_price'), true)
            ],
            [
                'label' => Trans::getWord('biayaDriver'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('trm_driver_fee'), true)
            ],
            [
                'label' => Trans::getWord('denda'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('trm_denda', '0'), true)
            ],
            [
                'label' => Trans::getWord('totalBiaya'),
                'value' => 'Rp ' . $number->doFormatFloat($total, true)
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to viewer price
     * @return Portlet
     */
    private function getPricePortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('pricePtl', Trans::getWord('harga') . '/Hari');
        $number = new NumberFormatter();

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('asset'),
                'value' => $this->getStringParameter('mb_variant')
            ],
            [
                'label' => Trans::getWord('harga') . '/Hari',
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('trm_price'), true)
            ],
            [
                'label' => Trans::getWord('driver'),
                'value' => $this->getStringParameter('dr_name')
            ],
            [
                'label' => Trans::getWord('driverFee') . '/Hari',
                'value' => $this->getIntParameter('trm_driver_fee')
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to viewer price
     * @return Portlet
     */
    private function getFieldPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('fieldPtl', Trans::getWord('pembayaran'));
        $portlet->setGridDimension(2, 6, 6);

        $fieldset = new FieldSet();
        $fieldset->setGridDimension(12, 6, 6);

        $mobil = $this->getHari() * $this->getIntParameter('trm_price');
        $driver = $this->getHari() * $this->getIntParameter('trm_driver_fee');
        $totalBiaya = $mobil + $driver;
        $asId = $this->getIntParameter('trm_as_id');
        $drId = $this->getIntParameter('trm_dr_id');
        $trId = $this->getIntParameter('tr_id');

        $row = $this->addRow([
            $fieldset->addField(Trans::getWord('biaya'), $this->Field->getText('tr_bayar', $this->getIntParameter('tr_bayar')), true),
            $fieldset->addField(Trans::getWord('denda'), $this->Field->getText('trm_denda', $this->getIntParameter('trm_denda'))),
            $fieldset->addHiddenField($this->Field->getHidden('tr_total', $this->getIntParameter('tr_total', $totalBiaya))),
            $fieldset->addHiddenField($this->Field->getHidden('as_id', $this->getIntParameter('as_id', $asId))),
            $fieldset->addHiddenField($this->Field->getHidden('dr_id', $this->getIntParameter('dr_id', $drId))),
            $fieldset->addHiddenField($this->Field->getHidden('tr_id', $this->getIntParameter('tr_id', $trId))),
        ]);
        $portlet->addFieldSet($row);

        return $portlet;
    }

}
