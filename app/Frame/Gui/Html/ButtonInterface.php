<?php


namespace App\Frame\Gui\Html;


use App\Frame\Gui\Html\HtmlInterface;

interface ButtonInterface extends HtmlInterface
{
    /**
     * Converts tha main property to a string and pass it to a variable.
     *
     * @return string
     */
    public function __toString();

    /**
     * Set the icon of the button.
     *
     * @param string $icon to store the icon name.
     *
     * @return Html
     */
    public function setIcon($icon);
}
