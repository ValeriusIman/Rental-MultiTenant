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
use App\Models\Dao\Relation\ContactPersonDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Relation
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class ContactPerson extends AbstractFormModel
{
    /**
     * ContactPerson constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('cp', 'cp_id');
        $this->setParameters($parameters);
        $this->setTitle('contactPerson');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'cp_ss_id' => $this->User->getSsId(),
            'cp_name' => $this->getStringParameter('cp_name'),
            'cp_phone' => $this->getStringParameter('cp_phone'),
            'cp_address' => $this->getStringParameter('cp_address'),
            'cp_active' => $this->getStringParameter('cp_active', 'Y')
        ];

        $cpDao = new ContactPersonDao();
        $cpDao->doInsertTransaction($colVal);
        return $cpDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'cp_ss_id' => $this->User->getSsId(),
            'cp_name' => $this->getStringParameter('cp_name'),
            'cp_phone' => $this->getStringParameter('cp_phone'),
            'cp_address' => $this->getStringParameter('cp_address'),
            'cp_active' => $this->getStringParameter('cp_active'),
        ];

        $cpDao = new ContactPersonDao();
        $cpDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return ContactPersonDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general',$this->generalField());
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('cp_name',3,255),
            $this->Validation->checkRequire('cp_phone'),
            $this->Validation->checkRequire('cp_address'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('CpPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        $row = $this->addRow([
            $field->addField(Trans::getWord('name'), $this->Field->getText('cp_name', $this->getStringParameter('cp_name')), true),
            $field->addField(Trans::getWord('phone'), $this->Field->getPhone('cp_phone', $this->getStringParameter('cp_phone')), true),
            $field->addField(Trans::getWord('address'), $this->Field->getTextArea('cp_address', $this->getStringParameter('cp_address')), true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('cp_active', $this->getStringParameter('cp_active','Y'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }
}
