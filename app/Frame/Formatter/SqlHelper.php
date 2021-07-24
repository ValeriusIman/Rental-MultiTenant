<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Formatter;

use App\Frame\Exceptions\Message;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Formatter
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SqlHelper
{
    /**
     * List of all available operator for sql conditions.
     *
     * @var array $OperatoreList
     */
    private static $OperatoreList = ['=', '>', '<', '>=', '<='];

    /**
     * Function to load data from database.
     *
     * @param string $columnName   to store the query selection.
     * @param string $value        to store the query selection.
     * @param string $operator to store the query selection.
     *
     * @return string
     */
    public static function generateStringCondition($columnName, $value, string $operator = '='): string
    {
        if(in_array($operator, self::$OperatoreList, true) === false) {
            Message::throwMessage('Invalid operator ('. $operator.') for generating sql string conditions.');
        }
        return '('.$columnName.' '.$operator.' \''.$value.'\')';
    }

    /**
     * Function to load data from database.
     *
     * @param string $columnName   to store the query selection.
     * @param string $value        to store the query selection.
     * @param string $operator to store the query selection.
     *
     * @return string
     */
    public static function generateNumericCondition($columnName, $value, string $operator = '='): string
    {
        if(in_array($operator, self::$OperatoreList, true) === false) {
            Message::throwMessage('Invalid operator ('. $operator.') for generating sql numeric conditions.');
        }
        return '('.$columnName.' '.$operator.' '.$value.')';
    }


    /**
     * Function to generate like query condition for sql
     *
     * @param string $columnName   to store the query selection.
     * @param string $value        to store the query selection.
     * @param string $matchingType to store the query selection
     *                             C => Contains
     *                             S => Start With
     *                             E => End With.
     *
     * @return string
     */
    public static function generateLikeCondition($columnName, $value, string $matchingType = 'C'): string
    {
        $string = '';
        if ($value !== null & is_string($value)) {
            $string = mb_strtolower(trim($value));
        }
        $matchingType = mb_strtolower($matchingType);
        if ($matchingType === 's') {
            $like = '\'' . $string . '%\'';
        } elseif ($matchingType === 'e') {
            $like = '\'%' . $string . '\'';
        } else {
            $like = '\'%' . $string . '%\'';
        }
        return '(LOWER(' . $columnName . ') like ' . $like . ')';
    }


    /**
     * Function to generate OrLike Condition for sql query.
     *
     * @param string $value        to store the query selection.
     * @param array  $columnNames  to store the query selection.
     * @param string $matchingType to store the query selection
     *                             C => Contains
     *                             S => Start With
     *                             E => End With.
     *
     * @return string
     */
    public static function generateOrLikeCondition(array $columnNames, $value, string $matchingType = 'c'): string
    {
        if (empty($columnNames) === true) {
            Message::throwMessage('Invalid columns name for generating or like condition.');
        }

        $orWheres = [];
        foreach ($columnNames as $column) {
            $orWheres[] = self::generateLikeCondition($column, $value, $matchingType);
        }
        return '(' . implode(' OR ', $orWheres) . ')';
    }
}
