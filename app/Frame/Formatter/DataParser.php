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
 * Class to handle converting of object.
 *
 * @package    app
 * @subpackage Frame\Formatter
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class DataParser
{

    /**
     * Function to parse the object data to normal array.
     *
     * @param \stdClass $object To store the data that will be parse.
     * @param array $attributes To store the attribute name that will be taken.
     *
     * @return array
     */
    public static function objectToArray($object, array $attributes = []): array
    {
        $result = [];
        if (\is_object($object) === true && $object !== null) {
            if (empty($attributes) === false) {
                foreach ($attributes as $attribute) {
                    $value = '';
                    if (property_exists($object, $attribute) === true) {
                        $value = $object->$attribute;
                    }
                    $result[$attribute] = $value;
                }
            } else {
                $result = get_object_vars($object);
            }
        }

        return $result;
    }


    /**
     * Function to parse the array object data to normal array.
     *
     * @param array $arrayObject To store the data that will be parse.
     * @param array $attributes  To store the attribute name that will be taken.
     *
     * @return array
     */
    public static function arrayObjectToArray(array $arrayObject, array $attributes = []): array
    {
        $result = [];
        if (empty($arrayObject) === false) {
            foreach ($arrayObject as $obj) {
                $result[] = self::objectToArray($obj, $attributes);
            }
        }

        return $result;
    }
}
