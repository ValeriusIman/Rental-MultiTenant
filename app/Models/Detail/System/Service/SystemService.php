<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\System\Service;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\System\Service\ServiceAjax;
use App\Models\Ajax\System\SystemSettingAjax;
use App\Models\Dao\System\Service\SystemServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\System\Service
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemService extends AbstractFormModel
{
    /**
     * SystemService constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('ssr', 'ssr_id');
        $this->setParameters($parameters);
        $this->setTitle('systemService');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'ssr_ss_id' => $this->getIntParameter('ssr_ss_id'),
            'ssr_srv_id' => $this->getIntParameter('ssr_srv_id'),
            'ssr_active' => $this->getStringParameter('ssr_active', 'Y'),
        ];

        $ssrDao = new SystemServiceDao();
        $ssrDao->doInsertTransaction($colVal);
        return $ssrDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'ssr_ss_id' => $this->getIntParameter('ssr_ss_id'),
            'ssr_srv_id' => $this->getIntParameter('ssr_srv_id'),
            'ssr_active' => $this->getStringParameter('ssr_active'),
        ];

        $ssrDao = new SystemServiceDao();
        $ssrDao->doUpdateTransaction($this->getDetailReferenceValue(),$colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return SystemServiceDao::getByReference($this->getDetailReferenceValue());
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
            $this->Validation->checkRequire('ssr_ss'),
            $this->Validation->checkRequire('ssr_srv'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('ssrPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        #systemSetting
        $systemSetting = $this->Field->getSingleSelect('ss', 'ssr_ss');
        $systemSetting->setShowData(SystemSettingAjax::loadSingleSelectData(), 'ss_relation');
        $systemSetting->setHiddenField('ssr_ss_id',$this->getIntParameter('ssr_ss_id'));

        #service
        $service = $this->Field->getSingleSelect('srv', 'ssr_srv');
        $service->setShowData(ServiceAjax::loadSingleSelectData(), 'srv_code');
        $service->setHiddenField('ssr_srv_id',$this->getIntParameter('ssr_srv_id'));

        #active
        $active = $this->Field->getYesNo('ssr_active', $this->getStringParameter('ssr_active','Y'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('systemSetting'), $systemSetting, true),
            $field->addField(Trans::getWord('service'), $service, true),
            $field->addField(Trans::getWord('active'), $active),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
