<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Custom\mmr\Viewer\Transaction\Transportasi;

use App\Frame\Formatter\NumberFormatter;
use App\Frame\Formatter\StringFormatter;
use App\Frame\Formatter\Trans;
use App\Frame\Gui\Portlet;

/**
 *
 *
 * @package    app
 * @subpackage Custom\mmr\Viewer\Transaction\Transportasi
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotor extends \App\Models\Viewer\Transaction\Transportasi\TransaksiSepedaMotor
{

    /**
     * function to viewer general
     * @return Portlet
     */
    public function getHargaPortlet(): Portlet
    {
        # Instantiate Portlet Object
        $portlet = new Portlet('hrPtl', Trans::getWord('harga') . '/Hari');
        $number = new NumberFormatter();
        $hargaPerJam = $this->getIntParameter('tsm_harga') / 24;
        $total = $hargaPerJam * $this->getJam();

        $content = StringFormatter::generateCustomTableView([
            [
                'label' => Trans::getWord('biayaSewa'),
                'value' => 'Rp ' . $number->doFormatFloat($total, true)
            ],
            [
                'label' => Trans::getWord('denda'),
                'value' => 'Rp ' . $number->doFormatFloat($total, true)
            ],
        ]);

        $portlet->addText($content);
        $portlet->setGridDimension(4, 6);

        return $portlet;
    }

}
