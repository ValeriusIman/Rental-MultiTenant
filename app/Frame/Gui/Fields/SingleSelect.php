<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Fields;

use App\Frame\Gui\Html\FieldsInterfaces;
use App\Frame\Gui\Html\Html;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Field
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SingleSelect extends Html implements FieldsInterfaces
{
    /**
     * @var string $Name
     */
    private $Name;


    /**
     * @var array $Data
     */
    private $Data;

    /**
     * @var string $Value
     */
    private $Value;

    /**
     * @var bool $ReadOnly
     */
    private $ReadOnly = false;

    /**
     * @var string $CallbackRoute
     */
    private $CallbackRoute;

    /**
     * @var string
     */
    private $ShowData;
    /**
     * @var string
     */
    private $InputHidden;
    /**
     * @var string
     */
    private $IdHidden;

    /**
     * Property set option data in select
     * @var string
     */
    private $IdData = '';

    private $OptionSelected = '';

    /**
     * SingleSelect constructor.
     * @param string $callbackRoute
     * @param string $name
     */
    public function __construct(string $callbackRoute, string $name)
    {
        $this->CallbackRoute = $callbackRoute;
        $this->Name = $name;
        $this->ShowData = "";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = $this->createSingleSelect();
        $result .= $this->InputHidden;
        return $result;
    }

    /**
     * function set readonly
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly = true): void
    {
        $this->ReadOnly = $readOnly;
    }

    /**
     * function to load data
     * @param array $data store array
     * @param string $field field database
     */
    public function setShowData(array $data, string $field): void
    {
        $this->Data = $data;
        $this->ShowData = $field;
    }

    /**
     * function to select2
     * @return string
     */
    private function createSingleSelect(): string
    {
        $readonly = '';
        if ($this->ReadOnly === true) {
            $readonly = 'disabled';
        }
        $result = '<select ' . $readonly . ' id="' . $this->Name . '" name="' . $this->Name . '" class="form-control select2" style="width: 100%;">';
        $result .= $this->loadSelect($this->Data);
        $result .= '</select>';
        $result .= $this->scriptSelect($this->Value);

        return $result;
    }

    public function setHiddenField($fieldId, $value): void
    {
        $this->Value = $value;
        $this->IdHidden = $fieldId;
        $this->InputHidden = '<input type="hidden" id="' . $fieldId . '" name="' . $fieldId . '" value="' . $value . '">';
    }

    public function setChildren($fieldId, $value): void
    {
        foreach ($this->Data as $row) {
            $this->IdData = 'data-' . $fieldId . '="' . $row[$value] . '"';
        }
        $this->OptionSelected = '$("#' . $fieldId . '").val(optionSelected.data("' . $fieldId . '"));';
    }

    /**
     * function to load data select2
     * @param array $data load data
     * @return string
     */
    private function loadSelect(array $data): string
    {
        $field = $this->ShowData;
        $id = $this->CallbackRoute . '_id';
        $option = '<option value=""></option>';
        foreach ($data as $row) {
            $option .= '<option class="code" data-' . $this->IdHidden . '="' . $row[$id] . '" ' . $this->IdData . ' value="' . $row[$id] . '">' . $row[$field] . '</option>';
        }
        return $option;
    }

    /**
     * function to load script select2
     * @param string $value
     * @return string
     */
    private function scriptSelect($value): string
    {
        $script = '<script>';
        $script .= '$(function () {';
        $script .= '$("#' . $this->Name . '").select2({';
        $script .= 'placeholder: "Select Data"}).on("change", function() {';
        $script .= 'var optionSelected = $(this).children("option:selected");';
        $script .= '$("#' . $this->IdHidden . '").val(optionSelected.data("' . $this->IdHidden . '"));';
        $script .= $this->OptionSelected;
        $script .= '}).val(' . $value . ').trigger("change");';
        $script .= '});';
        $script .= '</script>';
        return $script;
    }
}
