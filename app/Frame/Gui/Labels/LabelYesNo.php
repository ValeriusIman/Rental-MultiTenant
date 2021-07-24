<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Labels;

use App\Frame\Formatter\Trans;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Labels
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class LabelYesNo extends Label
{

    public function __construct($yesNo)
    {
        $type = '';
        $text = '';
        if ($yesNo === 'Y'){
            $type = 'info';
            $text = Trans::getWord('yes');
        }
        if ($yesNo === 'N'){
            $type = 'warning';
            $text = Trans::getWord('no');
        }

        parent::__construct($text, $type);
    }
}
