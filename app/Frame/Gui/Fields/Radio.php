<?php
/**
 * Contains code written by the PT Makmur Berkat Teknologi.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Matalogix
 * @author    Valerius Iman <valerius@mbteknologi.com>
 * @copyright 2021 PT Makmur Berkat Teknologi.
 */

namespace App\Frame\Gui\Fields;

use App\Frame\Gui\Html\FieldsInterfaces;
use App\Frame\Gui\Html\Html;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Fields
 * @author     Valerius Iman <valerius@mbteknologi.com>
 * @copyright  2021 PT Makmur Berkat Teknologi.
 */
class Radio extends Html implements FieldsInterfaces
{
    /**
     * Constructor to load when there is a new object created.
     *
     * @param string  $identifier The unique id of the radio button.
     * @param string  $value      The value to be given on the radio.
     * @param boolean $checked    When the radio button must be checked.
     */
    public function __construct($identifier, $value, $checked = false)
    {
        $this->setTag('input');
        $this->addAttribute('type', 'radio');
        $this->addAttribute('name', $identifier);
        $this->addAttribute('id', $identifier . '_' . $value);
        $this->addAttribute('value', $value);
        if ($checked === true) {
            $this->addAttribute('checked', 'checked');
        }
    }
}
