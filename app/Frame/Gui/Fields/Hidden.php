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
class Hidden extends Html implements FieldsInterfaces
{
    /**
     * Constructor to load when there is a new object created.
     *
     * @param string $id    The id of the element.
     * @param string $value The value of the element.
     */
    public function __construct($id, $value)
    {
        $this->setTag('input');
        $this->addAttribute('type', 'hidden');
        $this->addAttribute('name', $id);
        $this->addAttribute('id', $id);
        $this->addAttribute('value', $value);
    }
}
