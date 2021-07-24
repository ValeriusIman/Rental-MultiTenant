<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Custom\mmr\Detail\Transaction\Transportasi;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Portlet;
use App\Models\Ajax\System\SystemTypeAjax;

/**
 *
 *
 * @package    app
 * @subpackage Custom\mmr\Transaction\Transportasi
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotor extends \App\Models\Detail\Transaction\Transportasi\TransaksiSepedaMotor
{
    /**
     * function to load validation
     * @return void
     */
    public function loadValidation(): void
    {
        $this->Validation->setValidation([
            $this->Validation->checkRequire('tr_ata_date'),
        ]);
        parent::loadValidation();
    }

    /**
     * abstract function to field
     * @return Portlet
     */
    public function generalField(): Portlet
    {
        $portlet = new Portlet('tsmPtl', Trans::getWord('general'));
        $portlet->setGridDimension(6, 6, 12);

        $field = new FieldSet();
        $field->setGridDimension(6, 12, 12);

        $jaminan = $this->Field->getSelectData('sty', 'tr_jaminan_id', $this->getIntParameter('tr_jaminan_id'));
        $jaminan->setShowData(SystemTypeAjax::loadSingleSelectData('jaminan'), 'sty_name');

        $etaDate = $this->Field->getCalender('tr_eta_date', $this->getStringParameter('tr_eta_date'));
        $etaDate->enableStartDateNow();

        $ataDate = $this->Field->getCalender('tr_ata_date', $this->getStringParameter('tr_ata_date'));
        $ataDate->enableStartDateNow();

        $etaTime = $this->Field->getTime('tr_eta_time', $this->getStringParameter('tr_eta_time'));

        $row = $this->addRow([
            $field->addField(Trans::getWord('customer'), $this->Field->getText('tr_name_customer', $this->getStringParameter('tr_name_customer')), true),
            $field->addField(Trans::getWord('jaminan'), $jaminan, true),
            $field->addField(Trans::getWord('etaDate'), $etaDate, true),
            $field->addField(Trans::getWord('etaTime'), $etaTime, true),
            $field->addField(Trans::getWord('ataDate'), $ataDate, true)
        ]);
        $portlet->addFieldSet($row);
        parent::generalField();
        return $portlet;
    }

}
