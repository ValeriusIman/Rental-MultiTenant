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
use App\Models\Dao\Master\SepedaMotorDao;
use App\Models\Dao\Relation\DriverDao;
use App\Models\Dao\System\SystemTypeDao;
use App\Models\Dao\Transaction\TransaksiDao;
use App\Models\Dao\Transaction\Transportasi\TransaksiSepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Viewer\Transaction\Transportasi
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotor extends AbstractViewerModel
{

    /**
     * TransaksiSepedaMotor constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('tsm', 'tsm_tr_id');
        $this->setParameters($parameters);
        $this->setTitle(Trans::getWord('transaksiSepedaMotor'));
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

        #Transaksi Sepeda Motor
        $colTsmVal = [
            'tsm_denda' => $this->getIntParameter('trm_denda')
        ];
        $tsmDao = new TransaksiSepedaMotorDao();
        $tsmDao->doUpdateTransaction($this->getDetailReferenceValue(), $colTsmVal);

        #Sepeda Motor
        $motor = SepedaMotorDao::getPriceByAssetId($this->getIntParameter('as_id'));
        $sty = SystemTypeDao::getByName('Available');
        $colSpVal = [
            'sp_status_id' => $sty['sty_id']
        ];
        $spDao = new SepedaMotorDao();
        $spDao->doUpdateTransaction($motor['sp_id'], $colSpVal);


    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
//        dd(TransaksiSepedaMotorDao::getByTransaksiId($this->getDetailReferenceValue()));
        return TransaksiSepedaMotorDao::getByTransaksiId($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $data = $this->loadData();
        $this->setLabel($this->getStringParameter('tsm_tr_number'));
        $this->setView('general', $this->getGeneralPortlet());
        if ($data['tr_finish_on'] !== null) {
            $this->setView('detail', $this->getTotalBayarPortlet());
        }
        if ($data['tr_finish_on'] === null) {
            $this->setView('harga', $this->getHargaPortlet());
            $this->setView('pembayaran', $this->getFieldPortlet());
            $this->setEnableBtnFinish();
        }
        $this->setParams('tsm_tr_id');
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('tr_bayar', 4, 255, true),
        ]);
    }

    public function getJam(): int
    {
        $data = TransaksiSepedaMotorDao::getByTransaksiId($this->getDetailReferenceValue());
        $waktu = $data['tr_eta_date'] . ' ' . $data['tr_eta_time'];
        $waktuPeminjaman = (abs(strtotime($waktu)));
        $waktuSekarang = (abs(strtotime(date('Y-m-d H:i:s'))));
        return floor(($waktuSekarang - $waktuPeminjaman) / (60 * 60));
    }

    /**
     * function to viewer general
     * @return Portlet
     */
    private function getGeneralPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('gnlPtl', Trans::getWord('general'));
        $number = new NumberFormatter();
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('nama'),
                'value' => $this->getStringParameter('tr_name_customer')
            ],
            [
                'label' => Trans::getWord('jaminan'),
                'value' => $this->getStringParameter('tr_sty_jaminan')
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
            [
                'label' => Trans::getWord('asset'),
                'value' => $this->getStringParameter('tsm_sp_variant')
            ],
            [
                'label' => Trans::getWord('warna'),
                'value' => $this->getStringParameter('tsm_warna')
            ],
            [
                'label' => Trans::getWord('harga') . '/Hari',
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('tsm_sp_harga'), true)
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
    protected function getHargaPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('hrPtl', Trans::getWord('harga') . '/Hari');
        $number = new NumberFormatter();
        $hargaPerJam = $this->getIntParameter('tsm_harga') / 24;
        $total = $hargaPerJam * $this->getJam();

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('biayaSewa'),
                'value' => 'Rp ' . $number->doFormatFloat($total, true)
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(4, 6);

        return $portlet;
    }

    /**
     * function to viewer general
     * @return Portlet
     */
    private function getTotalBayarPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('tbPtl', Trans::getWord('detailPembayaran'));
        $number = new NumberFormatter();
        $kembalian = $this->getIntParameter('tr_bayar') - $this->getIntParameter('tr_total');

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('biayaSewa'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('tr_total'), true)
            ],
            [
                'label' => Trans::getWord('tunai'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('tr_bayar'), true)
            ],
            [
                'label' => Trans::getWord('denda'),
                'value' => 'Rp ' . $number->doFormatFloat($this->getIntParameter('tsm_denda'), true)
            ],
            [
                'label' => Trans::getWord('kembalian'),
                'value' => 'Rp ' . $number->doFormatFloat($kembalian, true)
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

        $hargaPerJam = $this->getIntParameter('tsm_harga') / 24;
        $total = $hargaPerJam * $this->getJam();
        $asId = $this->getIntParameter('tsm_as_id');
        $trId = $this->getIntParameter('tsm_tr_id');

        $row = $this->addRow([
            $fieldset->addField(Trans::getWord('biaya'), $this->Field->getText('tr_bayar', $this->getIntParameter('tr_bayar')), true),
            $fieldset->addField(Trans::getWord('denda'), $this->Field->getText('trm_denda', $this->getIntParameter('trm_denda'))),
            $fieldset->addHiddenField($this->Field->getHidden('tr_total', $this->getIntParameter('tr_total', $total))),
            $fieldset->addHiddenField($this->Field->getHidden('as_id', $this->getIntParameter('as_id', $asId))),
            $fieldset->addHiddenField($this->Field->getHidden('tr_id', $this->getIntParameter('tr_id', $trId))),
        ]);
        $portlet->addFieldSet($row);

        return $portlet;
    }


}
