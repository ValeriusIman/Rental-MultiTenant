<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\System;

use Illuminate\Support\MessageBag;
use Validator;

/**
 *
 *
 * @package    app
 * @subpackage Frame\System
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Validation
{
    /**
     * Attribute to set the method of the form.
     *
     * @var array $Rules
     */
    private $Rules = [];
    /**
     * Attribute to set the method of the form.
     *
     * @var array $Inputs
     */
    private $Inputs = [];
    /**
     * Attribute to set the method of the form.
     *
     * @var bool $Valid
     */
    private $Valid = true;
    /**
     * Attribute to set the trigger if the validation already execute.
     *
     * @var bool $ExecuteStatus
     */
    private $ExecuteStatus = false;

    /**
     * Attribute to store the error validation.
     *
     * @var MessageBag $Errors
     */
    private $Errors;

    /**
     * Validation constructor.
     */
    public function __construct()
    {
    }


    /**
     * Function to validate all the input value base on the rules.
     *
     * @return void
     */
    public function doValidation(): void
    {
        if (empty($this->Rules) === false) {
            $validator = Validator::make($this->Inputs, $this->Rules);
            if ($validator->fails()) {
                $this->Valid = false;
                $this->Errors = $validator->errors();
            }
        }
        $this->ExecuteStatus = true;
    }


    /**
     * Function to set the inputs that will be validate.
     *
     * @param array $inputs To store all the input value.
     *
     * @return void
     */
    public function setInputs($inputs): void
    {
//        dd($inputs);
        $this->Inputs = $inputs;
    }

    /**
     * Function to set the inputs that will be validate.
     *
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->ExecuteStatus;
    }

    /**
     * Function to check is there any invalid parameters.
     *
     * @return bool
     */
    public function isValidInputs(): bool
    {
        return $this->Valid;
    }

    /**
     * Function to set the rules.
     *
     * @param array $rules To store all the rules.
     *
     * @return void
     * @deprecated
     */
    public function setRules(array $rules): void
    {
        $this->Rules = array_merge($this->Rules, $rules);
    }

    /**
     * Function to get the error message.
     *
     * @param string $fieldId    To set the id of the field.
     * @param string $fieldAlias To set the id of the field.
     *
     * @return string
     */
    public function getErrorMessage($fieldId, $fieldAlias = ''): string
    {
        $result = '';
        if ($this->isValid($fieldId) === false) {
            $result = $this->Errors->first($fieldId);
            if (empty($fieldAlias) === false) {
                $key = str_replace('_', ' ', $fieldId);
                $result = str_replace($key, $fieldAlias, $result);
            }
        }

        return $result;
    }

    /**
     * Function to get the error message.
     *
     * @return array
     */
    public function getAllErrorMessage(): array
    {
        $results = [];
        if ($this->Errors !== null) {
            $fields = array_keys($this->Rules);
            foreach ($fields as $field) {
                if ($this->Errors->has($field) === true) {
                    $key = str_replace('_', ' ', $field);
                    $message = $this->Errors->first($field);
                    $results[] = str_replace($key, $field, $message);
                }
            }
        }

        return $results;
    }

    /**
     * Function to get the error message.
     *
     * @return string
     */
    public function getFirstErrorMessage(): string
    {
        $message = '';
        $errors = $this->getAllErrorMessage();
        if (empty($errors) === false) {
            $message = $errors[0];
        }

        return $message;
    }

    /**
     * Function to check is the field invalid or not.
     *
     * @param string $fieldId To set the id of the field.
     *
     * @return boolean
     */
    public function isValid($fieldId): bool
    {
        $result = true;
        if ($this->Errors !== null && $this->Errors->has($fieldId) === true) {
            $result = false;
        }

        return $result;
    }

    /**
     * Function to get old data.
     *
     * @param string $fieldId To set the id of the field.
     *
     * @return null|array|string
     */
    public function getOldValue($fieldId)
    {
        $result = '';
        if ($this->Valid === false && array_key_exists($fieldId, $this->Inputs) === true) {
            $result = $this->Inputs[$fieldId];
        }

        return $result;
    }

    /**
     * Function to add rule
     *
     * @param string $key  To store key of rule.
     * @param string $rule To store all the rule.
     *
     * @return void
     * @deprecated
     */
    public function addRule($key, $rule): void
    {
        if (empty($key) === false) {
            $this->Rules[$key] = $rule;
        }
    }

    /**
     * Function to check is the validation rule exist or not.
     *
     * @return boolean
     */
    public function isValidationExist(): bool
    {
        $result = true;
        if (empty($this->Rules) === true) {
            $result = false;
        }

        return $result;
    }

    /**
     * Function to check require
     *
     * @param string $fieldId   To set the id of the field.
     * @param int    $minLength To set the id of the field.
     * @param int    $maxLength To set the id of the field.
     *
     * @return void
     */
    public function checkRequire($fieldId, $minLength = -1, $maxLength = 0): void
    {
        if (empty($fieldId) === false) {
            $this->Rules[$fieldId][] = 'required';
            $this->checkMinLength($fieldId, $minLength);
            $this->checkMaxLength($fieldId, $maxLength);
        }
    }

    /**
     * Function to check require
     *
     * @param string $fieldId   To set the id of the field.
     * @param int    $minLength To set the id of the field.
     *
     * @return void
     */
    public function checkRequireArray($fieldId, $minLength = -1): void
    {
        if (empty($fieldId) === false) {
            $this->Rules[$fieldId][] = 'required';
            $this->Rules[$fieldId][] = 'array';
            $this->checkMinLength($fieldId, $minLength);
        }
    }

    /**
     * Function to check integer value
     *
     * @param string $fieldId  To set the id of the field.
     * @param string $minValue To set the min value of integer.
     * @param string $maxValue To set the id of the field.
     *
     * @return void
     */
    public function checkInt($fieldId, $minValue = 'undefined', $maxValue = 'undefined'): void
    {
        if (empty($fieldId) === false) {
            # generate the rule.
            $this->Rules[$fieldId][] = 'integer';
            if (is_numeric($minValue) === true) {
                $this->Rules[$fieldId][] = 'min:' . (int)$minValue;
            }
            if (is_numeric($maxValue) === true) {
                $this->Rules[$fieldId][] = 'max:' . (int)$maxValue;
            }
        }
    }

    /**
     * Function to check float value
     *
     * @param string $fieldId  To set the id of the field.
     * @param int    $minValue To set the min value of integer.
     * @param int    $maxValue To set the id of the field.
     *
     * @return void
     */
    public function checkFloat($fieldId, $minValue = null, $maxValue = null): void
    {
        if (empty($fieldId) === false) {
            # generate the rule.
            $this->Rules[$fieldId][] = 'numeric';
            if ($minValue !== null && is_numeric($minValue) === true) {
                $this->Rules[$fieldId][] = 'min:' . (int)$minValue;
            }
            if ($maxValue !== null && is_numeric($maxValue) === true) {
                $this->Rules[$fieldId][] = 'max:' . (int)$maxValue;
            }
        }
    }

    /**
     * Function to check date
     *
     * @param string $fieldId To set the id of the field.
     * @param string $format  To set the format of the date.
     * @param string $before  To set the validation before date.
     * @param string $after   To set the validation after date.
     *
     * @return void
     */
    public function checkDate($fieldId, $before = '', $after = '', $format = 'Y-m-d'): void
    {
        if (empty($fieldId) === false) {
            $this->Rules[$fieldId][] = 'date_format:' . $format;
            if (empty($before) === false) {
                $this->Rules[$fieldId][] = 'before:' . $before;
            }
            if (empty($after) === false) {
                $this->Rules[$fieldId][] = 'after:' . $after;
            }
        }
    }

    /**
     * Function to check time
     *
     * @param string $fieldId To set the id of the field.
     * @param string $format  To set the format of the time.
     *
     * @return void
     */
    public function checkTime($fieldId, $format = 'H:i'): void
    {
        if (empty($fieldId) === false) {
            $this->Rules[$fieldId][] = 'date_format:' . $format;
        }
    }

    /**
     * Function to check min length
     *
     * @param string  $fieldId  To set the id of the field.
     * @param integer $minValue To set the min value of integer.
     *
     * @return void
     */
    public function checkMinLength($fieldId, $minValue): void
    {
        if (empty($fieldId) === false && is_int($minValue) === true && $minValue >= 0) {
            $this->Rules[$fieldId][] = 'min:' . $minValue;
        }
    }

    /**
     * Function to check max length
     *
     * @param string  $fieldId  To set the id of the field.
     * @param integer $maxValue To set the id of the field.
     *
     * @return void
     */
    public function checkMaxLength($fieldId, $maxValue): void
    {
        if (empty($fieldId) === false && is_int($maxValue) === true && $maxValue > 0) {
            $this->Rules[$fieldId][] = 'max:' . $maxValue;
        }
    }

    /**
     * Function to check min length
     *
     * @param string  $fieldId  To set the id of the field.
     * @param integer $minValue To set the min value of integer.
     *
     * @return void
     */
    public function checkMinValue($fieldId, $minValue): void
    {
        if (empty($fieldId) === false && is_numeric($minValue) === true) {
            $this->Rules[$fieldId][] = 'min:' . $minValue;
        }
    }

    /**
     * Function to check max length
     *
     * @param string  $fieldId  To set the id of the field.
     * @param integer $maxValue To set the id of the field.
     *
     * @return void
     */
    public function checkMaxValue($fieldId, $maxValue): void
    {
        if (empty($fieldId) === false && is_numeric($maxValue) === true) {
            $this->Rules[$fieldId][] = 'max:' . $maxValue;
        }
    }

}
