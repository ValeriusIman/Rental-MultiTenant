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
 * @subpackage Frame\Gui\Fields
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class NumberPhone extends Text
{
    /**
     * @var string
     */
    private $Name;

    /**
     * @var string
     */
    private $Value;

    /**
     * @var bool $ReadOnly
     */
    private $ReadOnly = false;

    /**
     * Constructor to load when there is a new object created.
     *
     * @param string               $id    The id of the element.
     * @param string|integer|float $value The value of the element.
     */
    public function __construct($id, $value)
    {
        parent::__construct($id, $value);
        $this->addAttribute('data-inputmask', "'mask':'9999-9999-9999'");
        $this->addAttribute('data-mask', '');
    }

    public function __toString()
    {
        return $this->createNumber();
    }

    /**
     * Function to set the read only value.
     *
     * @param bool $readOnly to set the value of read only
     *
     * @return void
     */
    public function setReadOnly(bool $readOnly = true): void
    {
        if ($readOnly === true) {
            if (\in_array('readonly', $this->Attributes, true) === false) {
                $this->addAttribute('readonly', 'readonly');
            }
        } else {
            if (\in_array('readonly', $this->Attributes, true) === true) {
                unset($this->Attributes['readonly']);
            }
        }
    }

    /**
     * @return string
     */
    private function createNumber(): string
    {
        $result = parent::__toString();
        $result .= $this->script();
        return $result;
    }

    private function script(): string
    {
        $script = '<script>';
        $script .= '$(function() {';
        $script .= '$("[data-mask]").inputmask()});';
        $script .= '</script>';
        return $script;
    }
}
