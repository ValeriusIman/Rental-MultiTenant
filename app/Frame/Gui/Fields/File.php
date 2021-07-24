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
class File extends Text
{
    /**
     * @var string
     */
    private $Name;

    /**
     * File constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        parent::__construct($name,$value);
        $this->addAttribute('class','custom-file-input');
        $this->addAttribute('type','file');
        $this->Name = $name;
    }

    public function __toString()
    {
        return $this->createdFile();
    }

    /**
     * function to create html file
     * @return string
     */
    private function createdFile(): string
    {
        $result = '';
        $result .= '<div class="custom-file">';
        $result .= parent::__toString();
        $result .= '<label class="custom-file-label" for="' . $this->Name . '">Choose file</label>';
        $result .= '</div>';

        return $result;
    }
}
