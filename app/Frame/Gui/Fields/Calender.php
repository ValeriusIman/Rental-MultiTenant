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
class Calender extends Text
{
    /**
     * @var string
     */
    private $Name;

    /**
     * @var string
     */
    private $StartDate;

    /**
     * Property to store read only value.
     *
     * @var bool $ReadOnle
     */
    private $ReadOnly = false;

    /**
     * Date constructor.
     * @param string $id
     * @param $value
     */
    public function __construct(string $id, $value)
    {
        parent::__construct($id,$value);
        $this->Name = $id;
    }

    public function __toString()
    {
        return $this->createDate();
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
        parent::setReadOnly($readOnly);
        $this->ReadOnly = $readOnly;
    }

    public function enableStartDateNow($date = true): void
    {
        if ($date === true) {
            $this->StartDate = 'startDate: "+d",';
        }
        $this->StartDate;
    }

    /**
     * @return string
     */
    private function createDate(): string
    {
        if($this->ReadOnly === true) {
            return parent::__toString();
        }
        $result = '<div class="input-group">';
        $result .= parent::__toString();
        $result .= '<div class="input-group-prepend">';
        $result .= '<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= $this->script();
        return $result;
    }

    private function script(): string
    {
        $script = '<script>';
        $script .= '$(function() {';
        $script .= '$("#' . $this->Name . '").datepicker({';
        $script .= 'format: "yyyy-mm-dd",';
        $script .= $this->StartDate;
        $script .= '});';
        $script .= '});';
        $script .= '</script>';

        return $script;
    }
}
