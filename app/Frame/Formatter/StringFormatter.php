<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Formatter;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Formatter
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class StringFormatter
{
    /**
     * Function to parse the data from stdClass to array
     *
     * @param string $str to store the string to convert.
     * @param string $replaceTo to store the delimiter of conversion.
     *
     * @return string
     */
    public static function replaceSpecialCharacter($str, $replaceTo = ''): string
    {
        return preg_replace('/[^A-Za-z0-9]/', $replaceTo, $str);
    }

    /**
     * Function to generate table view.
     *
     * @param array $data To store the data.
     * @param integer $large To set the grid amount for a large screen.
     * @param integer $medium To set the grid amount for a medium screen.
     * @param integer $small To set the grid amount for a small screen.
     * @param bool $isShowEmptyVal To set the grid amount for a extra small screen.
     *
     * @return string
     */
    public static function generateCustomTableView(array $data = [], int $large = 12, int $medium = 12, int $small = 12, $isShowEmptyVal = true): string
    {
        $content = '<div class="card-body">';
        $content .= '<div class="col-lg-' . $large . ' col-md-' . $medium . ' col-sm-' . $small . ' col-xs-12">';
        $content .= '<table class="table">';
        $i = 0;
        foreach ($data as $row) {
            $val = $row['value'];
            if ($isShowEmptyVal === true || empty($val) === false) {
                if (empty($val) === true) {
                    $val = '-';
                }
                if (($i % 2) === 0) {
                    $content .= '<tr style="background: #E0E0FF">';
                } else {
                    $content .= '<tr>';
                }
                $content .= '<td>' . $row['label'] . '</td>';
                $content .= '<td style="font-weight: bold">' . $val . '</td>';
                $content .= '</tr>';
                $i++;
            }
        }
        $content .= '</table>';
        $content .= '</div>';
        $content .= '</div>';

        return $content;
    }
}
