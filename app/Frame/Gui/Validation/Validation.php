<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Validation;


use App\Frame\Formatter\DataParser;
use App\Frame\Formatter\SqlHelper;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Validation
{
    /**
     * @var string $Role
     */
    public $Role = '';

    /**
     * @var array $Massages
     */
    public $Massages = [];


    /**
     * function to check require
     * @param string $fieldId To set the id of the field.
     * @param int $minLength To set the id of the field.
     * @param int $maxLength To set the id of the field.
     * @param bool $number To set the id of the field.
     * @param bool $email To set the id of the field.
     * @return string
     */
    public function checkRequire($fieldId, $minLength = -1, $maxLength = 255, $number = false,$email=false): string
    {
        $require = $fieldId . ': {';
        $require .= 'required: true,';
        $require .= 'minlength: ' . $minLength . ',';
        $require .= 'maxlength: ' . $maxLength . ',';
        if ($number === true) {
            $require .= 'digits:true,';
        }
        if ($email === true) {
            $require .= 'email:true,';
        }
        $require .= '},';
        return $require;
    }

    public function checkNumber($fieldId,$minLength = 1, $maxLength = 255): string
    {
        $number = $fieldId . ': {';
        $number .= 'digits:true,';
        $number .= 'minlength: ' . $minLength . ',';
        $number .= 'maxlength: ' . $maxLength . ',';
        $number .= '},';
        return $number;
    }

    public function checkFloat($fieldId): string
    {
        $number = $fieldId . ': {';
        $number .= 'number:true,';
        $number .= '},';
        return $number;
    }

    /**
     * function to check File
     * @param $fieldId
     * @param $extension
     * @return string
     */
    public function checkFile($fieldId, $extension): string
    {
        $result = $fieldId . ': {';
        $result .= 'extension : "' . $extension . '"},';
        $massage = $fieldId . ':{extension: "Masukan format yang benar."},';
        $this->setMassages($massage);
        return $result;
    }

    public function checkUnique($fieldId, $tableName, array $ignoreFieldValue = [], array $uniqueFieldValue = []): string
    {
        $result = $fieldId . ': {';
        $result .= 'remote : {';
        $result .= 'url:"' . url('/validation') . '",';
        $result .= 'type:"POST",';
        $result .= '}},';

        return $result;
    }


    /**
     * function to set validation
     * @param array $data
     * @return string
     */
    public function setValidation(array $data): string
    {
        return $this->Role = implode($data);
    }

    /**
     * function to get validation
     * @return string
     */
    public function getValidation(): string
    {
        $role = 'rules: {';
        $role .= $this->Role;
        $role .= '},';
        return $role;
    }

    /**
     * function to set Massages
     * @param $massage
     * @return string
     */
    public function setMassages($massage): string
    {
        return $this->Massages[] = $massage;
    }

    /**
     * function to get massages
     * @return string
     */
    public function getMassages(): string
    {
        $massage = 'messages: {';
        $massage .= implode($this->Massages);
        $massage .= '},';
        return $massage;
    }

    /**
     * function to error placement
     * @return string
     */
    public function errorPlacement(): string
    {
        $error = 'errorPlacement: function(error, element) {';
        $error .= 'error.addClass("invalid-feedback");';
        $error .= 'element.closest(".validation").append(error);},';
        return $error;
    }

    /**
     * function to highlight
     * @return string
     */
    public function highlight(): string
    {
        $result = 'highlight: function(element, errorClass, validClass)';
        $result .= '{$(element).addClass("is-invalid");},';
        return $result;
    }

    /**
     * function to unhighlight
     * @return string
     */
    public function unhighlight(): string
    {
        $result = 'unhighlight: function(element, errorClass, validClass)';
        $result .= '{$(element).removeClass("is-invalid");}';
        return $result;
    }
}
