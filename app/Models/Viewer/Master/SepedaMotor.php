<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Viewer\Master;

use App\Frame\Formatter\StringFormatter;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractViewerModel;
use App\Models\Dao\Master\SepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Viewer\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SepedaMotor extends AbstractViewerModel
{

    /**
     * SepedaMotor constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('sp', 'sp_id');
        $this->setParameters($parameters);
        $this->setTitle(Trans::getWord('sepedaMotor'));
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
        return SepedaMotorDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setLabel($this->getStringParameter('sp_variant') . '|' . $this->getStringParameter('sp_as_code'));
        $this->setView('general', $this->getGeneralPortlet());
        $this->setView('spesifikasi', $this->getSpesifikasiPortlet());
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
    private function getGeneralPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('viewPtl', Trans::getWord('general'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('asset'),
                'value' => $this->getStringParameter('sp_as_code')
            ],
            [
                'label' => Trans::getWord('type'),
                'value' => $this->getStringParameter('sp_type_name')
            ],
            [
                'label' => Trans::getWord('warna'),
                'value' => $this->getStringParameter('sp_warna')
            ],
            [
                'label' => Trans::getWord('status'),
                'value' => $this->getStringParameter('sp_status_name')
            ],
            [
                'label' => Trans::getWord('harga') . '/Hari',
                'value' => $this->getIntParameter('sp_harga')
            ],
            [
                'label' => Trans::getWord('stnk'),
                'value' => $this->getStringParameter('sp_stnk')
            ],
            [
                'label' => Trans::getWord('bpkb'),
                'value' => $this->getStringParameter('sp_bpkb')
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
    private function getSpesifikasiPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('specPtl', Trans::getWord('spesifikasi'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('brand'),
                'value' => $this->getStringParameter('sp_brand')
            ],
            [
                'label' => Trans::getWord('variant'),
                'value' => $this->getStringParameter('sp_variant')
            ],
            [
                'label' => Trans::getWord('tahunBuat'),
                'value' => $this->getStringParameter('sp_tahun_pembuatan')
            ],
            [
                'label' => Trans::getWord('kapasitasTangki') . '(L)',
                'value' => $this->getFloatParameter('sp_kapasitas_tangki')
            ],
            [
                'label' => Trans::getWord('jenisTransmisi'),
                'value' => $this->getStringParameter('sp_transmisi')
            ],
            [
                'label' => Trans::getWord('typeInjeksi'),
                'value' => $this->getStringParameter('sp_type_injeksi')
            ],
            [
                'label' => Trans::getWord('jenisBahanBakar'),
                'value' => $this->getStringParameter('sp_bahan_bakar')
            ],
            [
                'label' => Trans::getWord('kapasitasMesin') . '(cc)',
                'value' => $this->getStringParameter('sp_cc')
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

}
