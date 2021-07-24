<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\Relation;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Dao\Relation\DriverDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Relation
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Driver extends AbstractFormModel
{

    /**
     * Driver constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('dr', 'dr_id');
        $this->setParameters($parameters);
        $this->setTitle('driver');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'dr_ss_id' => $this->User->getSsId(),
            'dr_name' => $this->getStringParameter('dr_name'),
            'dr_phone' => $this->getStringParameter('dr_phone'),
            'dr_address' => $this->getStringParameter('dr_address'),
            'dr_status' => $this->getStringParameter('dr_status', 'Y'),
            'dr_active' => $this->getStringParameter('dr_active', 'Y'),
        ];
        $drDao = new DriverDao();
        $drDao->doInsertTransaction($colVal);
        return $drDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'dr_name' => $this->getStringParameter('dr_name'),
            'dr_phone' => $this->getStringParameter('dr_phone'),
            'dr_address' => $this->getStringParameter('dr_address'),
            'dr_active' => $this->getStringParameter('dr_active')
        ];

        $drDao = new DriverDao();
        $drDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return DriverDao::getByReference($this->getDetailReferenceValue());
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
            $this->Validation->checkRequire('dr_name', 3, 255),
            $this->Validation->checkRequire('dr_phone'),
            $this->Validation->checkRequire('dr_address'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('DrPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        $row = $this->addRow([
            $field->addField(Trans::getWord('name'), $this->Field->getText('dr_name', $this->getStringParameter('dr_name')), true),
            $field->addField(Trans::getWord('phone'), $this->Field->getPhone('dr_phone', $this->getStringParameter('dr_phone')), true),
            $field->addField(Trans::getWord('address'), $this->Field->getTextArea('dr_address', $this->getStringParameter('dr_address')), true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('dr_active', $this->getStringParameter('dr_active','Y')))
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
