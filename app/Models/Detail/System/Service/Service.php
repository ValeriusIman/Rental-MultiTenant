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
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Dao\System\Service\ServiceDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\System\Service
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Service extends AbstractFormModel
{
    /**
     * Service constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('srv', 'srv_id');
        $this->setParameters($parameters);
        $this->setTitle('service');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'srv_code' => mb_strtolower($this->getStringParameter('srv_code')),
            'srv_name' => $this->getStringParameter('srv_name'),
            'srv_active' => $this->getStringParameter('srv_active', 'Y'),
        ];

        $srvDao = new ServiceDao();
        $srvDao->doInsertTransaction($colVal);
        return $srvDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'srv_code' => mb_strtolower($this->getStringParameter('srv_code')),
            'srv_name' => $this->getStringParameter('srv_name'),
            'srv_active' => $this->getStringParameter('srv_active'),
        ];

        $srvDao = new ServiceDao();
        $srvDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return ServiceDao::getByReference($this->getDetailReferenceValue());
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
            $this->Validation->checkRequire('srv_code', 2, 255),
            $this->Validation->checkRequire('srv_name', 2, 255)
        ]);
    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('srvPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 6, 6);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        $code = $this->Field->getText('srv_code', $this->getStringParameter('srv_code'));
        $service = $this->Field->getText('srv_name', $this->getStringParameter('srv_name'));
        $active = $this->Field->getYesNo('srv_active', $this->getStringParameter('srv_active','Y'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('code'), $code, true),
            $field->addField(Trans::getWord('service'), $service, true),
            $field->addField(Trans::getWord('active'), $active),
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
