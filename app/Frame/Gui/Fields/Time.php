<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Fields;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Fields
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Time extends Text
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
     * @var bool
     */
    public $ReadOnly;

    /**
     * Time constructor.
     * @param string $name
     * @param $value
     */
    public function __construct(string $name, $value)
    {
        parent::__construct($name, $value);
        $this->Name = $name;
    }

    public function __toString()
    {
        return $this->createTime();
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
    private function createTime(): string
    {
        if ($this->ReadOnly === true) {
            return parent::__toString();
        }
        $this->addAttribute('class', 'datetimepicker-input');
        $this->addAttribute('data-target', '#' . $this->Name);
        $result = '<div class="input-group date" id="' . $this->Name . '" data-target-input="nearest">';
        $result .= parent::__toString();
        $result .= '<div class="input-group-append" data-target="#' . $this->Name . '" data-toggle="datetimepicker">';
        $result .= '<div class="input-group-text"><i class="far fa-clock"></i></div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= $this->script();
        return $result;
    }

    private function script(): string
    {
        $script = '<script>';
        $script .= '$(function() {';
        $script .= '$("#' . $this->Name . '").datetimepicker({format: "H:m"})';
        $script .= '});';
        $script .= '</script>';

        return $script;
    }
}
