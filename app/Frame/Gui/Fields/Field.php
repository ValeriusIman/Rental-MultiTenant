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
class Field
{

    /**
     * function to form text
     * @param string $name name form input
     * @param string $value value input
     * @return Text
     */
    public function getText(string $name, $value): Text
    {
        return new Text($name, $value);
    }

    /**
     * function to form hidden
     * @param string $name name form input
     * @param string $value value input
     * @return Hidden
     */
    public function getHidden(string $name, $value): Hidden
    {
        return new Hidden($name, $value);
    }

    /**
     * function to form password
     * @param string $name name form input
     * @param string $value value input
     * @return Password
     */
    public function getPassword(string $name, $value): Password
    {
        return new Password($name, $value);
    }

    /**
     * function to form text
     * @param string $name name form input
     * @param string $value value input
     * @return NumberPhone
     */
    public function getPhone(string $name, $value): NumberPhone
    {
        return new NumberPhone($name, $value);
    }

    /**
     * function to form textarea
     * @param string $name name form textarea
     * @param string $value name form textarea
     * @param int    $numberOfRows To store the total rows for the text area.
     * @param int    $numberOfCols To store the total cols for the text area.
     * @return TextArea
     */
    public function getTextArea(string $name, $value,$numberOfRows = 3, $numberOfCols = 8): TextArea
    {
        return new TextArea($name, $value,$numberOfRows,$numberOfCols);
    }

    /**
     * function to form select2
     * @param string $prefix route/prefix
     * @param string $name name form select
     * @return SingleSelect
     */
    public function getSingleSelect(string $prefix, string $name): SingleSelect
    {
        return new SingleSelect($prefix, $name);
    }

    /**
     * function to radio button yesNo
     * @param string $name name radio button
     * @param string $value name radio button
     * @return YesNo
     */
    public function getYesNo(string $name, $value): YesNo
    {
        return new YesNo($name, $value);
    }

    /**
     * function to form file
     * @param string $name
     * @param $value
     * @return File
     */
    public function getFile(string $name, $value): File
    {
        return new File($name, $value);
    }

    /**
     * function to select data
     * @param string $prefix
     * @param string $name
     * @param $value
     * @return SelectData
     */
    public function getSelectData(string $prefix, string $name, $value): SelectData
    {
        return new SelectData($prefix, $name, $value);
    }

    /**
     * function to form date
     * @param string $name
     * @param $value
     * @return Calender
     */
    public function getCalender(string $name, $value): Calender
    {
        return new Calender($name, $value);
    }

    public function getTime(string $name, $value): Time
    {
        return new Time($name, $value);
    }
}
