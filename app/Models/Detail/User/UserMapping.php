<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\User;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\System\SystemSettingAjax;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Ajax\User\UserAjax;
use App\Models\Dao\User\UserMappingDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\User
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class UserMapping extends AbstractFormModel
{
    /**
     * UserMapping constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('ump', 'ump_id');
        $this->setParameters($parameters);
        $this->setTitle('userMapping');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'ump_us_id' => $this->getIntParameter('us_id'),
            'ump_ss_id' => $this->getIntParameter('ump_ss_id'),
            'ump_level_id' => $this->getIntParameter('ump_level_id'),
            'ump_default' => 'N',
            'ump_active' => $this->getStringParameter('ump_active','Y')
        ];

        $umpDao = new UserMappingDao();
        $umpDao->doInsertTransaction($colVal);
        return $umpDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'ump_ss_id' => $this->getIntParameter('ump_ss_id'),
            'ump_level_id' => $this->getIntParameter('ump_level_id'),
            'ump_active' => $this->getStringParameter('ump_active'),
        ];

        $umpDao = new UserMappingDao();
        $umpDao->doUpdateTransaction($this->getDetailReferenceValue(),$colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return UserMappingDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('general', $this->generalField());
        $this->setUrlBtnClose('us');
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('ump_ss_id'),
            $this->Validation->checkRequire('ump_level_id'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('umpPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6,12,12);

        $field = new FieldSet();
        $field->setGridDimension(6,12,12);

        $systemSetting = $this->Field->getSingleSelect('ss','ump_ss');
        $systemSetting->setShowData(SystemSettingAjax::loadSingleSelectData(),'ss_relation');
        $systemSetting->setHiddenField('ump_ss_id',$this->getIntParameter('ump_ss_id'));

        $userAccess = $this->Field->getSelectData('sty','ump_level_id',$this->getIntParameter('ump_level_id'));
        $userAccess->setShowData(SystemTypeAjax::loadSingleSelectData('useraccess'),'sty_name');

        $row = $this->addRow([
            $field->addField(Trans::getWord('systemSetting'),$systemSetting,true),
            $field->addField(Trans::getWord('userAccess'),$userAccess,true),
            $field->addField(Trans::getWord('active'),$this->Field->getYesNo('ump_active',$this->getStringParameter('ump_active','Y'))),
            $field->addField(Trans::getWord('active'),$this->Field->getHidden('us_id',$this->getIntParameter('us_id'))),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
