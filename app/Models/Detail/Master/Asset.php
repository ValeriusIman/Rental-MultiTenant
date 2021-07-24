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
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Ajax\System\Service\ServiceAjax;
use App\Models\Dao\Master\AssetDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Master
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Asset extends AbstractFormModel
{
    /**
     * Asset constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('as','as_id');
        $this->setParameters($parameters);
        $this->setTitle('asset');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {
        $colVal = [
            'as_ss_id' => $this->User->getSsId(),
            'as_srv_id' => $this->getIntParameter('as_srv_id'),
            'as_code' => $this->getStringParameter('as_code'),
            'as_active' => $this->getStringParameter('as_active', 'Y')
        ];

        $asDao = new AssetDao();
        $asDao->doInsertTransaction($colVal);
        return $asDao->getLastInsertId();
    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {
        $colVal = [
            'as_ss_id' => $this->User->getSsId(),
            'as_srv_id' => $this->getIntParameter('as_srv_id'),
            'as_code' => $this->getStringParameter('as_code'),
            'as_active' => $this->getStringParameter('as_active'),
        ];

        $asDao = new AssetDao();
        $asDao->doUpdateTransaction($this->getDetailReferenceValue(), $colVal);
    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return AssetDao::getByReference($this->getDetailReferenceValue());
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
            $this->Validation->checkRequire('as_code', 5, 255),
            $this->Validation->checkRequire('as_srv_code'),
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('AssPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 4, 4);

        $field = new FieldSet();
        $field->setGridDimension(6, 4, 4);

        #service
        $service = $this->Field->getSingleSelect('srv', 'as_srv_code');
        $service->setShowData(ServiceAjax::loadSingleSelectData(), 'srv_code');
        $service->setHiddenField('as_srv_id',$this->getIntParameter('as_srv_id'));

        #code
        $code = $this->Field->getText('as_code', $this->getStringParameter('as_code'));

        #active
        $active = $this->Field->getYesNo('as_active', $this->getStringParameter('as_active','Y'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('service'), $service, true),
            $field->addField(Trans::getWord('code'), $code, true),
            $field->addField(Trans::getWord('active'), $active)
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }
}
