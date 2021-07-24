<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\System;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Dao\System\SystemSettingDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemSetting extends AbstractFormModel
{
    /**
     * SystemSetting constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('ss', 'ss_id');
        $this->setParameters($parameters);
        $this->setTitle('systemSetting');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $logoName = '';
        $file = $this->getFileParameter('ss_logo');
        $nameSpace = $this->getStringParameter('ss_name_space');
        if ($file !== null) {
            $logoName = strtolower($nameSpace . time() . '.' . $file->getClientOriginalExtension());
        }
        $colVal = [
            'ss_relation' => $this->getStringParameter('ss_relation'),
            'ss_decimal_number' => $this->getIntParameter('ss_decimal_number'),
            'ss_decimal_separator' => $this->getStringParameter('ss_decimal_separator'),
            'ss_thousand_separator' => $this->getStringParameter('ss_thousand_separator'),
            'ss_name_space' => $this->getStringParameter('ss_name_space'),
            'ss_system' => $this->getStringParameter('ss_system', 'N'),
            'ss_active' => $this->getStringParameter('ss_active', 'Y'),
            'ss_logo' => $logoName,
        ];

        $ssDao = new SystemSettingDao();
        $ssDao->doInsertTransaction($colVal);
        $ssDao->upload($file, $nameSpace, $logoName);
        return $ssDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $logoName = '';
        $file = $this->getFileParameter('ss_logo');
        $nameSpace = $this->getStringParameter('ss_name_space');
        if ($file !== null) {
            $logoName = strtolower($nameSpace . time() . '.' . $file->getClientOriginalExtension());
        }

        $colVal = [
            'ss_relation' => $this->getStringParameter('ss_relation'),
            'ss_decimal_number' => $this->getIntParameter('ss_decimal_number'),
            'ss_decimal_separator' => $this->getStringParameter('ss_decimal_separator'),
            'ss_thousand_separator' => $this->getStringParameter('ss_thousand_separator'),
            'ss_name_space' => $this->getStringParameter('ss_name_space'),
            'ss_active' => $this->getStringParameter('ss_active'),
            'ss_logo' => $logoName,
        ];

        $ssById = SystemSettingDao::getByReference($this->getDetailReferenceValue());
        $ssDao = new SystemSettingDao();
        if ($file !== null) {
            $ssDao->doDeleteFile($ssById['ss_logo'], $ssById['ss_name_space']);
            $ssDao->upload($file, $nameSpace, $logoName);
        }
        $ssDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return SystemSettingDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general', $this->generalField());
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {

        $this->Validation->setValidation([
            $this->Validation->checkRequire('ss_relation', 5, 255),
            $this->Validation->checkRequire('ss_name_space', 2, 255),
            $this->Validation->checkRequire('ss_decimal_number', 1, 2),
            $this->Validation->checkRequire('ss_decimal_separator', 1, 1),
            $this->Validation->checkRequire('ss_thousand_separator', 1, 1),
            $this->Validation->checkRequire('ss_logo', 1, 255),
            $this->Validation->checkFile('ss_logo', 'JPG|PNG'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('ssPtl', Trans::getWord('general'));
        $portlet->setGridDimension(12, 6, 6);

        $field = new FieldSet();
        $field->setGridDimension(6, 6, 6);

        $relation = $this->Field->getText('ss_relation', $this->getStringParameter('ss_relation'));
        $nameSpace = $this->Field->getText('ss_name_space', $this->getStringParameter('ss_name_space'));
        $decimalNumber = $this->Field->getText('ss_decimal_number', $this->getStringParameter('ss_decimal_number'));
        $decimalSeparator = $this->Field->getText('ss_decimal_separator', $this->getStringParameter('ss_decimal_separator'));
        $thousandSeparator = $this->Field->getText('ss_thousand_separator', $this->getStringParameter('ss_thousand_separator'));
        $active = $this->Field->getYesNo('ss_active', $this->getStringParameter('ss_active', 'Y'));
        $logo = $this->Field->getFile('ss_logo', '');

        $row = $this->addRow([
            $field->addField(Trans::getWord('relation'), $relation, true),
            $field->addField(Trans::getWord('nameSpace'), $nameSpace, true),
            $field->addField(Trans::getWord('logo'), $logo, true),
            $field->addField(Trans::getWord('decimalNumber'), $decimalNumber, true),
            $field->addField(Trans::getWord('decimalSeparator'), $decimalSeparator, true),
            $field->addField(Trans::getWord('thousandSeparator'), $thousandSeparator, true),
            $field->addField(Trans::getWord('active'), $active),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
