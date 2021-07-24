<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Detail\Master\Perpustakaan;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Frame\Gui\Validation;
use App\Frame\Mvc\AbstractFormModel;
use App\Models\Dao\Master\Perpustakaan\RakDao;

/**
 *
 *
 * @package    app
 * @subpackage Detail\Master\Perpustakaan
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Rak extends AbstractFormModel
{
    /**
     * Rak constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        parent::__construct('rb', 'rb_id');
        $this->setParameters($parameters);
        $this->setTitle('rak');
    }

    /**
     * function to insert
     * @return int
     */
    public function doInsert(): int
    {

    }

    /**
     * function to update
     * @return void
     */
    public function doUpdate(): void
    {

    }

    /**
     * function to load data
     * @return array
     */
    public function loadData(): array
    {
        return RakDao::getByReference($this->getDetailReferenceValue());
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
            # TODO: Set the validation rule here.
        ]);

    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('PtlRak', Trans::getWord('general'));
        $portlet->setGridDimension(12,12,12);

        $field = new FieldSet();
        $field->setGridDimension(12,12,12);



        $row = $this->addRow([
            $field->addField(Trans::getWord('kategori'),$this->Field->getText('rb_kategori',$this->getStringParameter('rb_kategori')))
        ]);
        $portlet->addFieldSet($row);
        return $portlet;
    }

}
