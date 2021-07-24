<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Buttons;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Button
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SubmitButton extends Button
{

    /**
     * SubmitButton constructor.
     * @param string $id
     * @param string $value
     */
    public function __construct(string $id,$value)
    {
        parent::__construct($id, $value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $this->setTag('button');
        $this->DefaultClass;
        $this->SizeStyle;
        return parent::__toString();
    }
}
