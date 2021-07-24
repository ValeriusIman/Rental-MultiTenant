<?php


namespace App\Frame\Gui\Html;


interface FieldsInterfaces extends HtmlInterface
{
    /**
     * Converts tha main property to a string and pass it to a variable.
     *
     * @return string
     */
    public function __toString();
}
