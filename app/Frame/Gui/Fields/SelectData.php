<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Fields;

use App\Frame\Gui\Html\FieldsInterfaces;
use App\Frame\Gui\Html\Html;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui\Fields
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class SelectData extends Html implements FieldsInterfaces
{

    /**
     * @var string $Name
     */
    private $Name;

    /**
     * @var array $Data
     */
    private $Data;

    /**
     * @var string $Value
     */
    private $Value;

    /**
     * @var bool $ReadOnly
     */
    private $ReadOnly = false;

    /**
     * @var string $CallbackRoute
     */
    private $CallbackRoute;

    /**
     * @var string
     */
    private $ShowData;

    /**
     * SelectData constructor.
     * @param string $callbackRoute
     * @param string $name
     * @param $value
     */
    public function __construct(string $callbackRoute, string $name, $value)
    {
        $this->CallbackRoute = $callbackRoute;
        $this->Name = $name;
        $this->Value = $value;
        $this->ShowData = "";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->createSelectData();
    }

    /**
     * function set readonly
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly = true): void
    {
        $this->ReadOnly = $readOnly;
    }

    public function setShowData(array $data, string $field): void
    {
        $this->Data = $data;
        $this->ShowData = $field;
    }

    /**
     * function to select2
     * @return string
     */
    private function createSelectData(): string
    {
        $readonly = '';
        if ($this->ReadOnly === true) {
            $readonly = 'disabled';
        }
        $result = '<select ' . $readonly . ' id="' . $this->Name . '" name="' . $this->Name . '" class="form-control select2" style="width: 100%;">';
        $result .= $this->loadSelect($this->Data);
        $result .= '</select>';

        return $result;
    }

    /**
     * function to load data select2
     * @param array $data load data
     * @return string
     */
    private function loadSelect(array $data): string
    {
        $field = $this->ShowData;
        $id = $this->CallbackRoute . '_id';
        $option = '<option value="">Select Data</option>';
        foreach ($data as $row) {
            $select = '';
            if ($this->Value === $row[$id]) {
                $select = "selected";
            }
            $option .= '<option value="' . $row[$id] . '" ' . $select . '>' . $row[$field] . '</option>';
        }
        return $option;
    }
}
