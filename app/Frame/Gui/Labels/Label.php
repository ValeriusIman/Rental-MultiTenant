<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Labels;

use App\Frame\Gui\Html\Html;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Labels
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Label extends Html
{
    /**
     * Attribute to store text
     * @var string $Text
     */
    public $Text;

    /**
     * Attribute to store type
     * @var string $Type
     */
    public $Type = '';

    /**
     * Label constructor.
     * @param $text
     * @param string $type
     */
    public function __construct($text, $type = 'primary')
    {
        $this->Text = $text;
        $this->Type = $type;
        $this->setTag('span');
        $this->addAttribute('class','badge badge-'.$type);
        $this->addContent($text);
    }

}
