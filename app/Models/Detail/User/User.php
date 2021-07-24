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
use App\Frame\Gui\Table;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\System\SystemSettingAjax;
use App\Models\Ajax\System\SystemTypeAjax;
use App\Models\Dao\User\UserDao;
use App\Models\Dao\User\UserMappingDao;
use Illuminate\Support\Facades\Hash;

/**
 *
 *
 * @package    app
 * @subpackage Detail\User
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class User extends AbstractFormModel
{
    /**
     * User constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('us','us_id');
        $this->setParameters($parameters);
        $this->setTitle('user');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colValUs = [
            'us_name' => $this->getStringParameter('us_name'),
            'us_username' => $this->getStringParameter('us_username'),
            'us_password' => Hash::make($this->getStringParameter('us_password')),
            'us_system' => 'N',
            'us_active' => $this->getStringParameter('us_active', 'Y')
        ];

        $usDao = new UserDao();
        $usDao->doInsertTransaction($colValUs);
        $userId = $usDao->getLastInsertId();

        $colValUmp = [
            'ump_us_id' => $userId,
            'ump_ss_id' => $this->getIntParameter('ump_ss_id'),
            'ump_default' => 'Y',
            'ump_active' => $this->getStringParameter('ump_active', 'Y'),
            'ump_level_id' => $this->getIntParameter('ump_level_id')
        ];

        $umpDao = new UserMappingDao();
        $umpDao->doInsertTransaction($colValUmp);

        return $userId;
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colValUs = [
            'us_name' => $this->getStringParameter('us_name'),
            'us_active' => $this->getStringParameter('us_active')
        ];

        $usDao = new UserDao();
        $usDao->doUpdateTransaction($this->getDetailReferenceValue(),$colValUs);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return UserDao::getByReference($this->getDetailReferenceValue());
    }

    /**
     * function to load form
     * @return void
     */
    public function loadForm(): void
    {
        $this->setView('user', $this->generalField());
        if ($this->isInsert()) {
            $this->setView('userMapping', $this->userMappingField());
        }
        $this->loadTable();
    }

    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('us_name', 2, 255),
            $this->Validation->checkRequire('us_email', 5, 255, false, true),
            $this->Validation->checkRequire('us_password', 5, 255),
            $this->Validation->checkRequire('ump_ss'),
            $this->Validation->checkRequire('ump_level_id'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('usPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 12, 12);
        if ($this->isUpdate()) {
            $portlet = new Portlet('usPtl', Trans::getWord('general'));
            $portlet->setGridDimension(12, 12, 12);
        }

        $field = new FieldSet();
        $field->setGridDimension(6, 12, 12);

        $email = $this->Field->getText('us_username', $this->getStringParameter('us_username'));

        $password = $this->Field->getPassword('us_password', $this->getStringParameter('us_password'));
        if ($this->isUpdate()) {
            $email->setReadOnly();
            $password->setReadOnly();
        }
        $row = $this->addRow([
            $field->addField(Trans::getWord('name'), $this->Field->getText('us_name', $this->getStringParameter('us_name')), true),
            $field->addField(Trans::getWord('email'), $email, true),
            $field->addField(Trans::getWord('password'), $password, true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('us_active', $this->getStringParameter('us_active','Y')))
        ]);
        if ($this->isUpdate()) {
            $email->setReadOnly();
            $password->setReadOnly();
        }
        $portlet->addFieldSet($row);
        return $portlet;
    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function userMappingField(): Portlet
    {
        $portlet = new Portlet('umpPtl', Trans::getWord('userMapping'));
        $portlet->setGridDimension(6, 12, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 12, 12);

        #systemSetting
        $systemSetting = $this->Field->getSingleSelect('ss', 'ump_ss');
        $systemSetting->setShowData(SystemSettingAjax::loadSingleSelectData(), 'ss_relation');
        $systemSetting->setHiddenField('ump_ss_id',$this->getIntParameter('ump_ss_id'));
        #userAccess
        $userAccess = $this->Field->getSelectData('sty', 'ump_level_id', $this->getIntParameter('ump_level_id'));
        $userAccess->setShowData(SystemTypeAjax::loadSingleSelectData('useraccess'), 'sty_name');

        $row = $this->addRow([
            $field->addField(Trans::getWord('systemSetting'), $systemSetting, true),
            $field->addField(Trans::getWord('userAccess'), $userAccess, true),
            $field->addField(Trans::getWord('active'), $this->Field->getYesNo('ump_active', $this->getStringParameter('us_active')))
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

    public function loadTable(): void
    {
        $wheres[] = '(ump.ump_us_id = ' . $this->getDetailReferenceValue() . ')';
        $this->Table->setPrefix('ump');
        $this->Table->setUserId($this->getDetailReferenceValue());
        $this->Table->setHeader([
            'ss_relation' => Trans::getWord('systemSetting'),
            'ump_sty_name' => Trans::getWord('level'),
            'ump_default' => Trans::getWord('default'),
            'ump_active' => Trans::getWord('active')
        ]);
        $this->Table->setRows(UserMappingDao::loadData($wheres));
        $this->Table->addColumnAttribute('ump_default', 'style', 'text-align:center');
        $this->Table->addColumnAttribute('ump_active', 'style', 'text-align:center');
        $this->Table->setEnableButtonNew();
        $this->Table->setEnableButtonEdit(true,'ump_id');
        $this->Table->setTitle(Trans::getWord('userMapping'));
    }
}
