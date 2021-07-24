<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Viewer\Master;

use App\Frame\Formatter\NumberFormatter;
use App\Frame\Formatter\StringFormatter;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractViewerModel;
use App\Models\Dao\Master\MobilDao;

/**
 *
 *
 * @package    app
 * @subpackage Models\Viewer\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Mobil extends AbstractViewerModel
{

    /**
     * Mobil constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('mb', 'mb_id');
        $this->setParameters($parameters);
        $this->setTitle(Trans::getWord('mobil'));
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {

    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return MobilDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to validation
     * @return void
     */
    public function loadValidation(): void
    {

    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setLabel($this->getStringParameter('mb_variant'));
        $this->setView('general',$this->getGeneralPortlet());
        $this->setView('specification',$this->getSpecificationPortlet());
        $this->setView('performance',$this->getPerformancePortlet());
    }

    /**
     * function to generate view
     * @return Portlet
     */
    private function getGeneralPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('GlPtl', Trans::getWord('general'));
        $number = new NumberFormatter();
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('asset'),
                'value' => $this->getStringParameter('mb_as_code')
            ],
            [
                'label' => Trans::getWord('type'),
                'value' => $this->getStringParameter('mb_sty_type')
            ],
            [
                'label' => Trans::getWord('warna'),
                'value' => $this->getStringParameter('mb_sty_color')
            ],
            [
                'label' => Trans::getWord('status'),
                'value' => $this->getStringParameter('mb_status')
            ],
            [
                'label' => Trans::getWord('harga').'/Hari',
                'value' => 'Rp. ' . $number->doFormatFloat($this->getIntParameter('mb_price'), true)
            ],
            [
                'label' => Trans::getWord('stnk'),
                'value' => $this->getStringParameter('mb_stnk')
            ],
            [
                'label' => Trans::getWord('bpkb'),
                'value' => $this->getStringParameter('mb_bpkb')
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to generate view
     * @return Portlet
     */
    private function getSpecificationPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('SpecPtl', Trans::getWord('general'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('brand'),
                'value' => $this->getStringParameter('mb_brand')
            ],
            [
                'label' => Trans::getWord('variant'),
                'value' => $this->getStringParameter('mb_variant')
            ],
            [
                'label' => Trans::getWord('tahunBuat'),
                'value' => $this->getIntParameter('mb_built_year')
            ],
            [
                'label' => Trans::getWord('jenisTransmisi'),
                'value' => $this->getStringParameter('mb_transmisi')
            ],
            [
                'label' => Trans::getWord('girboks'),
                'value' => $this->getStringParameter('mb_girboks')
            ],
            [
                'label' => Trans::getWord('panjang').'(mm)',
                'value' => $this->getIntParameter('mb_length')
            ],
            [
                'label' => Trans::getWord('lebar').'(mm)',
                'value' => $this->getIntParameter('mb_width')
            ],
            [
                'label' => Trans::getWord('tinggi').'(mm)',
                'value' => $this->getIntParameter('mb_height')
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to generate view
     * @return Portlet
     */
    private function getPerformancePortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('PerformancePtl', Trans::getWord('general'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('jenisBahanBakar'),
                'value' => $this->getStringParameter('mb_fty_name')
            ],
            [
                'label' => Trans::getWord('kapasitasMesin'),
                'value' => $this->getIntParameter('mb_cc')
            ],
            [
                'label' => Trans::getWord('tenaga'),
                'value' => $this->getIntParameter('mb_tenaga')
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

    /**
     * function to generate view
     * @return Portlet
     */
    private function getFasilitasPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('FasilitasPtl', Trans::getWord('general'));
        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('fuelType'),
                'value' => $this->getStringParameter('mb_fty_name')
            ],
            [
                'label' => Trans::getWord('engineCapacity'),
                'value' => $this->getIntParameter('mb_cc')
            ],
            [
                'label' => Trans::getWord('power'),
                'value' => $this->getIntParameter('mb_tenaga')
            ],
        ]);
        $portlet->addText($content);
        $portlet->setGridDimension(6, 6);

        return $portlet;
    }

}
