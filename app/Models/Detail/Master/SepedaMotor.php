<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\Master;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\Master\AssetAjax;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Dao\Master\SepedaMotorDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SepedaMotor extends AbstractFormModel
{
    /**
     * SepedaMotor constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('sp', 'sp_id');
        $this->setParameters($parameters);
        $this->setTitle('sepedaMotor');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'sp_as_id' => $this->getIntParameter('sp_as_id'),
            'sp_warna_id' => $this->getIntParameter('sp_warna_id'),
            'sp_type_id' => $this->getIntParameter('sp_type_id'),
            'sp_status_id' => $this->getIntParameter('sp_status_id'),
            'sp_bahan_bakar' => $this->getStringParameter('sp_bahan_bakar'),
            'sp_brand' => $this->getStringParameter('sp_brand'),
            'sp_variant' => $this->getStringParameter('sp_variant'),
            'sp_tahun_pembuatan' => $this->getStringParameter('sp_tahun_pembuatan'),
            'sp_harga' => $this->getIntParameter('sp_harga'),
            'sp_cc' => $this->getIntParameter('sp_cc'),
            'sp_type_injeksi' => $this->getStringParameter('sp_type_injeksi'),
            'sp_kapasitas_tangki' => $this->getFloatParameter('sp_kapasitas_tangki'),
            'sp_transmisi' => $this->getStringParameter('sp_transmisi'),
            'sp_stnk' => $this->getStringParameter('sp_stnk'),
            'sp_bpkb' => $this->getStringParameter('sp_bpkb'),
            'sp_active' => $this->getStringParameter('sp_active')
        ];

        $spDao = new SepedaMotorDao();
        $spDao->doInsertTransaction($colVal);
        return $spDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'sp_as_id' => $this->getIntParameter('sp_as_id'),
            'sp_warna_id' => $this->getIntParameter('sp_warna_id'),
            'sp_type_id' => $this->getIntParameter('sp_type_id'),
            'sp_status_id' => $this->getIntParameter('sp_status_id'),
            'sp_bahan_bakar' => $this->getStringParameter('sp_bahan_bakar'),
            'sp_brand' => $this->getStringParameter('sp_brand'),
            'sp_variant' => $this->getStringParameter('sp_variant'),
            'sp_tahun_pembuatan' => $this->getStringParameter('sp_tahun_pembuatan'),
            'sp_harga' => $this->getIntParameter('sp_harga'),
            'sp_cc' => $this->getIntParameter('sp_cc'),
            'sp_type_injeksi' => $this->getStringParameter('sp_type_injeksi'),
            'sp_kapasitas_tangki' => $this->getFloatParameter('sp_kapasitas_tangki'),
            'sp_transmisi' => $this->getStringParameter('sp_transmisi'),
            'sp_stnk' => $this->getStringParameter('sp_stnk'),
            'sp_bpkb' => $this->getStringParameter('sp_bpkb'),
            'sp_active' => $this->getStringParameter('sp_active')
        ];

        $spDao = new SepedaMotorDao();
        $spDao->doUpdateTransaction($this->getDetailReferenceValue(),$colVal);
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
        $this->setView('general', $this->generalField());
        $this->setView('spesifikasi', $this->spesifikasiField());
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('sp_as_code'),
            $this->Validation->checkRequire('sp_type'),
            $this->Validation->checkRequire('sp_warna'),
            $this->Validation->checkRequire('sp_status_id'),
            $this->Validation->checkRequire('sp_harga', 4, 10, true),
            $this->Validation->checkRequire('sp_stnk', 2, 255),
            $this->Validation->checkRequire('sp_bpkb', 2, 255),
            $this->Validation->checkRequire('sp_brand', 2, 255),
            $this->Validation->checkRequire('sp_variant', 2, 255),
            $this->Validation->checkRequire('sp_transmisi', 2, 255),
            $this->Validation->checkRequire('sp_bahan_bakar', 2, 255),
            $this->Validation->checkRequire('sp_cc', 2, 255, true),
            $this->Validation->checkNumber('sp_tahun_pembuatan'),
            $this->Validation->checkFloat('sp_kapasitas_tangki'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('spPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 6, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 6, 6);

        #asset
        $asset = $this->Field->getSingleSelect('as', 'sp_as_code');
        $asset->setShowData(AssetAjax::loadSingleSelectData($this->User->getSsId(), 'sepedamotor'), 'as_code');
        $asset->setHiddenField('sp_as_id', $this->getIntParameter('sp_as_id'));
        #type
        $type = $this->Field->getSingleSelect('sty', 'sp_type');
        $type->setShowData(SystemTypeAjax::loadSingleSelectData('bodytype'), 'sty_name');
        $type->setHiddenField('sp_type_id', $this->getIntParameter('sp_type_id'));
        #warna
        $warna = $this->Field->getSingleSelect('sty', 'sp_warna');
        $warna->setShowData(SystemTypeAjax::loadSingleSelectData('color'), 'sty_name');
        $warna->setHiddenField('sp_warna_id', $this->getIntParameter('sp_warna_id'));
        #status
        $status = $this->Field->getSelectData('sty', 'sp_status_id', $this->getIntParameter('sp_status_id'));
        $status->setShowData(SystemTypeAjax::loadSingleSelectData('status'), 'sty_name');

        $row = $this->addRow([
            $field->addField(Trans::getWord('asset'), $asset, true),
            $field->addField(Trans::getWord('type'), $type, true),
            $field->addField(Trans::getWord('warna'), $warna, true),
            $field->addField(Trans::getWord('status'), $status, true),
            $field->addField(Trans::getWord('harga') . '/Hari', $this->Field->getText('sp_harga', $this->getIntParameter('sp_harga')), true),
            $field->addField(Trans::getWord('stnk'), $this->Field->getText('sp_stnk', $this->getStringParameter('sp_stnk')), true),
            $field->addField(Trans::getWord('bpkb'), $this->Field->getText('sp_bpkb', $this->getStringParameter('sp_bpkb')), true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('sp_active', $this->getStringParameter('sp_active', 'Y'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function spesifikasiField(): Portlet
    {
        $portlet = new Portlet('specPtl', Trans::getWord('spesifikasi'));
        $portlet->setGridDimension(6, 6, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 6, 6);

        $row = $this->addRow([
            $field->addField(Trans::getWord('brand'), $this->Field->getText('sp_brand', $this->getStringParameter('sp_brand')), true),
            $field->addField(Trans::getWord('variant'), $this->Field->getText('sp_variant', $this->getStringParameter('sp_variant')), true),
            $field->addField(Trans::getWord('tahunBuat'), $this->Field->getText('sp_tahun_pembuatan', $this->getStringParameter('sp_tahun_pembuatan'))),
            $field->addField(Trans::getWord('kapasitasTangki').'(L)', $this->Field->getText('sp_kapasitas_tangki', $this->getFloatParameter('sp_kapasitas_tangki'))),
            $field->addField(Trans::getWord('jenisTransmisi'), $this->Field->getText('sp_transmisi', $this->getStringParameter('sp_transmisi')), true),
            $field->addField(Trans::getWord('typeInjeksi'), $this->Field->getText('sp_type_injeksi', $this->getStringParameter('sp_type_injeksi'))),
            $field->addField(Trans::getWord('jenisBahanBakar'), $this->Field->getText('sp_bahan_bakar', $this->getStringParameter('sp_bahan_bakar')), true),
            $field->addField(Trans::getWord('kapasitasMesin') . '(cc)', $this->Field->getText('sp_cc', $this->getIntParameter('sp_cc')), true),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
