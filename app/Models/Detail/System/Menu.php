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
use App\Models\Ajax\System\Service\ServiceAjax;
use App\Models\Ajax\System\Service\SystemServiceAjax;
use App\Models\Dao\System\MenuDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Menu extends AbstractFormModel
{
    /**
     * Menu constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('mn', 'mn_id');
        $this->setParameters($parameters);
        $this->setTitle('menu');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'mn_srv_id' => $this->getIntParameter('mn_srv_id'),
            'mn_name' => $this->getStringParameter('mn_name'),
            'mn_route' => $this->getStringParameter('mn_route'),
            'mn_icon' => $this->getStringParameter('mn_icon'),
            'mn_sub_menu' => $this->getStringParameter('mn_sub_menu'),
            'mn_active' => $this->getStringParameter('mn_active'),
        ];

        $mnDao = new MenuDao();
        $mnDao->doInsertTransaction($colVal);
        return $mnDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'mn_srv_id' => $this->getIntParameter('mn_srv_id'),
            'mn_name' => $this->getStringParameter('mn_name'),
            'mn_route' => $this->getStringParameter('mn_route'),
            'mn_icon' => $this->getStringParameter('mn_icon'),
            'mn_sub_menu' => $this->getStringParameter('mn_sub_menu'),
            'mn_active' => $this->getStringParameter('mn_active'),
        ];

        $mnDao = new MenuDao();
        $mnDao->doUpdateTransaction($this->getDetailReferenceValue(),$colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return MenuDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('', $this->generalField());
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('mn_name',2,255),
            $this->Validation->checkRequire('mn_route',2,255),
            $this->Validation->checkRequire('mn_icon',2,255),
            $this->Validation->checkRequire('mn_sub_menu',2,255),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('MnPtl', Trans::getWord('general'));
        $portlet->setGridDimension(12, 6, 6);

        $field = new FieldSet();
        $field->setGridDimension(4, 4, 4);

        $service = $this->Field->getSingleSelect('srv', 'srv_name');
        $service->setShowData(ServiceAjax::loadSingleSelectData(), 'srv_name');
        $service->setHiddenField('mn_srv_id', $this->getIntParameter('mn_srv_id'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('service'), $service),
            $field->addField(Trans::getWord('name'), $this->Field->getText('mn_name', $this->getStringParameter('mn_name')), true),
            $field->addField(Trans::getWord('subMenu'), $this->Field->getText('mn_sub_menu', $this->getStringParameter('mn_sub_menu')), true),
            $field->addField(Trans::getWord('route'), $this->Field->getText('mn_route', $this->getStringParameter('mn_route')), true),
            $field->addField(Trans::getWord('icon'), $this->Field->getText('mn_icon', $this->getStringParameter('mn_icon')), true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('mn_active', $this->getStringParameter('mn_active', 'Y')))
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
