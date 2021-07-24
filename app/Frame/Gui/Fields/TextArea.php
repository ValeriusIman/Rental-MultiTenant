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
class TextArea extends Html implements FieldsInterfaces
{

    /**
     * TextArea constructor.
     * @param string $name
     * @param string  $value The value of the element.
     * @param integer $rows  Number of rows for the text area.
     * @param integer $cols  Number of columns for the text area.
     */
    public function __construct(string $name, $value, $rows, $cols)
    {
        $this->setTag('textarea');
        $this->addAttribute('name', $name);
        $this->addAttribute('id', $name);
        $this->addAttribute('rows', $rows);
        $this->addAttribute('cols', $cols);
        $this->addAttribute('class', 'form-control');
        $this->addContent($value);
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
}
