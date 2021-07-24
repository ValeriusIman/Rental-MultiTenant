<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui;


use App\Frame\Gui\Fields\File;
use App\Frame\Gui\Fields\NumberPhone;
use App\Frame\Gui\Fields\SelectData;
use App\Frame\Gui\Fields\SingleSelect;
use App\Frame\Gui\Fields\Text;
use App\Frame\Gui\Fields\TextArea;
use App\Frame\Gui\Fields\YesNo;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class FieldSet
{
    /**
     * attribute to store all lg html
     * @var int $Large
     */
    public $Large = 0;

    /**
     * attribute to store all md html
     * @var int $Medium
     */
    public $Medium = 0;

    /**
     * attribute to store all sm html
     * @var int $Small
     */
    public $Small = 0;

    /**
     * @var int $ExtraSmall
     */
    public $ExtraSmall = 0;

    /**
     * @var string $ColumnGridClass
     */
    public $ColumnGridClass = '';

    /**
     * @var string $Column
     */
    public $Column = '';

    public function __construct()
    {
        $this->setGridDimension();
    }

    /**
     * function set Grid dimension
     * @param int $large
     * @param int $medium
     * @param int $small
     * @param int $extraSmall
     */
    public function setGridDimension(int $large = 3, int $medium = 4, int $small = 4, int $extraSmall = 12): void
    {
        $this->Large = $large;
        $this->Medium = $medium;
        $this->Small = $small;
        $this->ExtraSmall = $extraSmall;
        $this->ColumnGridClass = 'form-group col-lg-' . $large . ' col-md-' . $medium . ' col-sm-' . $small;
        $this->Column = 'col-lg-' . $large . ' col-md-' . $medium . ' col-sm-' . $small . ' col-xl-' . $extraSmall;
    }

    /**
     * function to add field
     * @param string $label
     * @param $field
     * @param bool $require
     * @return string
     */
    public function addField(string $label, $field, bool $require = false): string
    {
        $lab = $this->label($label, $require);
        return $this->getFormGroup($field, $lab);
    }

    /**
     * function to add field
     * @param $field
     * @return string
     */
    public function addHiddenField($field): string
    {
        return $this->getFormGroup($field);
    }

    /**
     * function to set label require
     * @param $name
     * @param $require
     * @return string
     */
    public function label($name, $require): string
    {
        $label = '';
        if ($require === true) {
            $label = '<span style="color: red">*</span>';
        }
        return '<label for="' . strtolower($name) . '" class="' . $this->Column . ' col-form-label">' . $name . $label . '</label>';
    }

    /**
     * function to form group
     * @param $label
     * @param $field
     * @return string
     */
    public function getFormGroup($field, $label = ''): string
    {
        $result = '<div class="' . $this->ColumnGridClass . ' is-invalid">';
        $result .= $label;
        $result .= '<div class="validation ' . $this->Column . '">';
        $result .= $field;
        $result .= '</div>';
        $result .= '</div>';
        return $result;
    }


}
