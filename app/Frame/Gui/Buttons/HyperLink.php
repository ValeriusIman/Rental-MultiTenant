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
 * @subpackage Frame\Gui\Buttons
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class HyperLink extends Button
{

    /**
     * Property to store the url
     *
     * @var string $Url
     */
    private $Url = '';

    /**
     * Property to store position style
     *
     * @var bool $ButtonView
     */
    private $ButtonView = false;

    /**
     * Constructor to load when there is a new object created.
     *
     * @param string $id The id of the element.
     * @param string $value The value of the element.
     * @param string $url The link address.
     */
    public function __construct($id, $value, $url)
    {
        parent::__construct($id, $value);
        $this->Url = $url;

    }

    /**
     * Function to set view as hyperlink
     *
     * @return void
     */
    public function viewAsHyperlink(): void
    {
        $this->ButtonView = false;
    }

    public function __toString()
    {
        if ($this->ButtonView === false) {
            $this->setTag('a');
            $this->DefaultClass;
            $this->SizeStyle;
            $this->Submit;
            $this->addAttribute('href', $this->Url);
        }
        return parent::__toString();
    }

}
