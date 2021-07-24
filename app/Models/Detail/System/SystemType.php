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
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Dao\System\SystemTypeDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemType extends AbstractFormModel
{
    /**
     * SystemType constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('sty', 'sty_id');
        $this->setParameters($parameters);
        $this->setTitle('systemType');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'sty_group' => mb_strtolower($this->getStringParameter('sty_group')),
            'sty_name' => $this->getStringParameter('sty_name'),
            'sty_active' => $this->getStringParameter('sty_active', 'Y'),
        ];

        $styDao = new SystemTypeDao();
        $styDao->doInsertTransaction($colVal);
        return $styDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'sty_group' => mb_strtolower($this->getStringParameter('sty_group')),
            'sty_name' => $this->getStringParameter('sty_name'),
            'sty_active' => $this->getStringParameter('sty_active'),
        ];

        $styDao = new SystemTypeDao();
        $styDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return SystemTypeDao::getByReference($this->getDetailReferenceValue());
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
            $this->Validation->checkRequire('sty_group', 2, 255),
            $this->Validation->checkRequire('sty_name', 2, 255),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('styPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        $group = $this->Field->getText('sty_group', $this->getStringParameter('sty_group'));
        $name = $this->Field->getText('sty_name', $this->getStringParameter('sty_name'));
        $active = $this->Field->getYesNo('sty_active', $this->getStringParameter('sty_active','Y'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('code'), $group, true),
            $field->addField(Trans::getWord('name'), $name, true),
            $field->addField(Trans::getWord('active'), $active),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
