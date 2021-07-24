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
use Ramsey\Uuid\Fields\FieldsInterface;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Field
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Text extends Html implements FieldsInterfaces
{

    /**
     * Constructor to load when there is a new object created.
     *
     * @param string               $id    The id of the element.
     * @param string|integer|float $value The value of the element.
     */
    public function __construct($id, $value)
    {
        $this->setTag('input');
        $this->addAttribute('type', 'text');
        $this->addAttribute('name', $id);
        $this->addAttribute('id', $id);
        $this->addAttribute('value', $value);
        $this->addAttribute('class', 'form-control input-sm');
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
