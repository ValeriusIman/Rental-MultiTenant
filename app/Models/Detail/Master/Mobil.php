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
use App\Models\Dao\Master\MobilDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Mobil extends AbstractFormModel
{
    /**
     * Mobil constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('mb', 'mb_id');
        $this->setParameters($parameters);
        $this->setTitle('mobil');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'mb_as_id' => $this->getIntParameter('mb_as_id'),
            'mb_color_id' => $this->getIntParameter('mb_color_id'),
            'mb_status_id' => $this->getIntParameter('mb_status_id'),
            'mb_type_id' => $this->getIntParameter('mb_type_id'),
            'mb_price' => $this->getIntParameter('mb_price'),
            'mb_stnk' => $this->getStringParameter('mb_stnk'),
            'mb_bpkb' => $this->getStringParameter('mb_bpkb'),
            'mb_active' => $this->getStringParameter('mb_active', 'Y'),
            'mb_fty_id' => $this->getIntParameter('mb_fty_id'),
            'mb_cc' => $this->getIntParameter('mb_cc'),
            'mb_tenaga' => $this->getIntParameter('mb_tenaga'),
            'mb_brand' => $this->getStringParameter('mb_brand'),
            'mb_variant' => $this->getStringParameter('mb_variant'),
            'mb_built_year' => $this->getStringParameter('mb_built_year'),
            'mb_transmisi' => $this->getStringParameter('mb_transmisi'),
            'mb_girboks' => $this->getStringParameter('mb_girboks'),
            'mb_length' => $this->getIntParameter('mb_length'),
            'mb_width' => $this->getIntParameter('mb_width'),
            'mb_height' => $this->getIntParameter('mb_height'),
            'mb_seat' => $this->getIntParameter('mb_seat'),
            'mb_pintu' => $this->getIntParameter('mb_pintu'),
            'mb_ac' => $this->getStringParameter('mb_ac'),
            'mb_kamera_belakang' => $this->getStringParameter('mb_kamera_belakang'),
            'mb_power_steering' => $this->getStringParameter('mb_power_steering'),
            'mb_kursi_lipat' => $this->getStringParameter('mb_kursi_lipat'),
            'mb_abs' => $this->getStringParameter('mb_abs'),
            'mb_airbag_pengemudi' => $this->getStringParameter('mb_airbag_pengemudi'),
            'mb_airbag_penumpang' => $this->getStringParameter('mb_airbag_penumpang'),
            'mb_sabuk_pengaman' => $this->getStringParameter('mb_sabuk_pengaman'),
        ];

        $mbDao = new MobilDao();
        $mbDao->doInsertTransaction($colVal);
        return $mbDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'mb_as_id' => $this->getIntParameter('mb_as_id'),
            'mb_color_id' => $this->getIntParameter('mb_color_id'),
            'mb_status_id' => $this->getIntParameter('mb_status_id'),
            'mb_type_id' => $this->getIntParameter('mb_type_id'),
            'mb_price' => $this->getIntParameter('mb_price'),
            'mb_stnk' => $this->getStringParameter('mb_stnk'),
            'mb_bpkb' => $this->getStringParameter('mb_bpkb'),
            'mb_active' => $this->getStringParameter('mb_active', 'Y'),
            'mb_fty_id' => $this->getIntParameter('mb_fty_id'),
            'mb_cc' => $this->getIntParameter('mb_cc'),
            'mb_tenaga' => $this->getIntParameter('mb_tenaga'),
            'mb_brand' => $this->getStringParameter('mb_brand'),
            'mb_variant' => $this->getStringParameter('mb_variant'),
            'mb_built_year' => $this->getStringParameter('mb_built_year'),
            'mb_transmisi' => $this->getStringParameter('mb_transmisi'),
            'mb_girboks' => $this->getStringParameter('mb_girboks'),
            'mb_length' => $this->getIntParameter('mb_length'),
            'mb_width' => $this->getIntParameter('mb_width'),
            'mb_height' => $this->getIntParameter('mb_height'),
            'mb_seat' => $this->getIntParameter('mb_seat'),
            'mb_pintu' => $this->getIntParameter('mb_pintu'),
            'mb_ac' => $this->getStringParameter('mb_ac'),
            'mb_kamera_belakang' => $this->getStringParameter('mb_kamera_belakang'),
            'mb_power_steering' => $this->getStringParameter('mb_power_steering'),
            'mb_kursi_lipat' => $this->getStringParameter('mb_kursi_lipat'),
            'mb_abs' => $this->getStringParameter('mb_abs'),
            'mb_airbag_pengemudi' => $this->getStringParameter('mb_airbag_pengemudi'),
            'mb_airbag_penumpang' => $this->getStringParameter('mb_airbag_penumpang'),
            'mb_sabuk_pengaman' => $this->getStringParameter('mb_sabuk_pengaman'),
        ];

        $mbDao = new MobilDao();
        $mbDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
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
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general', $this->generalField());
        $this->setView('specification', $this->specificationField());
        $this->setView('performance', $this->performanceField());
        $this->setView('fasilitas', $this->fasilitasField());
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('mb_as_code'),
            $this->Validation->checkRequire('mb_color'),
            $this->Validation->checkRequire('mb_status_id'),
            $this->Validation->checkRequire('mb_type'),
            $this->Validation->checkRequire('mb_price', 3, 6, true),
            $this->Validation->checkNumber('mb_cc'),
            $this->Validation->checkNumber('mb_tenaga'),
            $this->Validation->checkNumber('mb_seat'),
            $this->Validation->checkNumber('mb_pintu'),
            $this->Validation->checkNumber('mb_length'),
            $this->Validation->checkNumber('mb_width'),
            $this->Validation->checkNumber('mb_height'),
            $this->Validation->checkNumber('mb_built_year', 2, 4),
            $this->Validation->checkRequire('mb_transmisi', 2, 255),
            $this->Validation->checkRequire('mb_stnk'),
            $this->Validation->checkRequire('mb_bpkb'),
            $this->Validation->checkRequire('mb_brand', 3, 255),
            $this->Validation->checkRequire('mb_fty_id'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('gnlPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);


        #asset
        $asset = $this->Field->getSingleSelect('as', 'mb_as_code');
        $asset->setShowData(AssetAjax::loadSingleSelectData($this->User->getSsId(),'mobil'), 'as_code');
        $asset->setHiddenField('mb_as_id', $this->getIntParameter('mb_as_id'));
        #color
        $color = $this->Field->getSingleSelect('sty', 'mb_color');
        $color->setShowData(SystemTypeAjax::loadSingleSelectData('color'), 'sty_name');
        $color->setHiddenField('mb_color_id', $this->getIntParameter('mb_color_id'));
        #status
        $status = $this->Field->getSelectData('sty', 'mb_status_id', $this->getIntParameter('mb_status_id'));
        $status->setShowData(SystemTypeAjax::loadSingleSelectData('status'), 'sty_name');
        #type
        $type = $this->Field->getSingleSelect('sty', 'mb_type');
        $type->setShowData(SystemTypeAjax::loadSingleSelectData('typecar'), 'sty_name');
        $type->setHiddenField('mb_type_id', $this->getIntParameter('mb_type_id'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('asset'), $asset, true),
            $field->addField(Trans::getWord('type'), $type, true),
            $field->addField(Trans::getWord('warna'), $color, true),
            $field->addField(Trans::getWord('status'), $status, true),
            $field->addField(Trans::getWord('harga') . '/Hari', $this->Field->getText('mb_price', $this->getIntParameter('mb_price')), true),
            $field->addField(Trans::getWord('stnk'), $this->Field->getText('mb_stnk', $this->getStringParameter('mb_stnk')), true),
            $field->addField(Trans::getWord('bpkb'), $this->Field->getText('mb_bpkb', $this->getStringParameter('mb_bpkb')), true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('mb_active', $this->getStringParameter('mb_active', 'Y'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * function to portlet performance
     * @return Portlet
     */
    public function performanceField(): Portlet
    {
        $portlet = new Portlet('perPtl', Trans::getWord('performa'));
        $portlet->setGridDimension(4, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(12, 4, 4);

        #bbm
        $fuelType = $this->Field->getSingleSelect('sty', 'mb_fty');
        $fuelType->setShowData(SystemTypeAjax::loadSingleSelectData('fueltype'), 'sty_name');
        $fuelType->setHiddenField('mb_fty_id', $this->getIntParameter('mb_fty_id'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('jenisBahanBakar'), $fuelType, true),
            $field->addField(Trans::getWord('kapasitasMesin') . '(cc)', $this->Field->getText('mb_cc', $this->getIntParameter('mb_cc'))),
            $field->addField(Trans::getWord('tenaga') . '(hp)', $this->Field->getText('mb_tenaga', $this->getIntParameter('mb_tenaga'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * function to portlet performance
     * @return Portlet
     */
    public function specificationField(): Portlet
    {
        $portlet = new Portlet('specPtl', Trans::getWord('spesifikasi'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        $row = $this->addRow([
            $field->addField(Trans::getWord('brand'), $this->Field->getText('mb_brand', $this->getStringParameter('mb_brand')), true),
            $field->addField(Trans::getWord('variant'), $this->Field->getText('mb_variant', $this->getStringParameter('mb_variant'))),
            $field->addField(Trans::getWord('tahunBuat'), $this->Field->getText('mb_built_year', $this->getStringParameter('mb_built_year'))),
            $field->addField(Trans::getWord('jenisTransmisi'), $this->Field->getText('mb_transmisi', $this->getStringParameter('mb_transmisi')), true),
            $field->addField(Trans::getWord('girboks'), $this->Field->getText('mb_girboks', $this->getStringParameter('mb_girboks'))),
            $field->addField(Trans::getWord('panjang') . '(mm)', $this->Field->getText('mb_length', $this->getIntParameter('mb_length'))),
            $field->addField(Trans::getWord('lebar') . '(mm)', $this->Field->getText('mb_width', $this->getIntParameter('mb_width'))),
            $field->addField(Trans::getWord('tinggi') . '(mm)', $this->Field->getText('mb_height', $this->getIntParameter('mb_height'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * function to portlet performance
     * @return Portlet
     */
    public function fasilitasField(): Portlet
    {
        $portlet = new Portlet('fasilitasPtl', Trans::getWord('fasilitas'));
        $portlet->setGridDimension(8, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(4, 4, 4);

        $row = $this->addRow([
            $field->addField(Trans::getWord('kapasitasTempatDuduk'), $this->Field->getText('mb_seat', $this->getIntParameter('mb_seat'))),
            $field->addField(Trans::getWord('jumlahPintu'), $this->Field->getText('mb_pintu', $this->getIntParameter('mb_pintu'))),
            $field->addField(Trans::getWord('ac'), $this->Field->getYesNo('mb_ac', $this->getStringParameter('mb_ac'))),
            $field->addField(Trans::getWord('kameraBelakang'), $this->Field->getYesNo('mb_kamera_belakang', $this->getStringParameter('mb_kamera_belakang'))),
            $field->addField(Trans::getWord('powerSteering'), $this->Field->getYesNo('mb_power_steering', $this->getStringParameter('mb_power_steering'))),
            $field->addField(Trans::getWord('kursiLipatBelakang'), $this->Field->getYesNo('mb_kursi_lipat', $this->getStringParameter('mb_kursi_lipat'))),
            $field->addField(Trans::getWord('antiLockBrakingSystem'), $this->Field->getYesNo('mb_abs', $this->getStringParameter('mb_abs'))),
            $field->addField(Trans::getWord('airbagPenumpangDepan'), $this->Field->getYesNo('mb_airbag_pengemudi', $this->getStringParameter('mb_airbag_pengemudi'))),
            $field->addField(Trans::getWord('airbagSampingBelakang'), $this->Field->getYesNo('mb_airbag_penumpang', $this->getStringParameter('mb_airbag_penumpang'))),
            $field->addField(Trans::getWord('sabukPengamanBelakang'), $this->Field->getYesNo('mb_sabuk_pengaman', $this->getStringParameter('mb_sabuk_pengaman'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }
}
