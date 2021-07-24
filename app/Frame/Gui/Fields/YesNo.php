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
 * @subpackage Frame\Gui\Field
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class YesNo extends Html implements FieldsInterfaces
{

    /**
     * The yes radio object.
     *
     * @var Radio $Yes
     */
    private $Yes;

    /**
     * The no radio object.
     *
     * @var Radio $No
     */
    private $No;

    /**
     * Selected value.
     *
     * @var string Selected value.
     */
    private $Selected;

    /**
     * Selected value.
     *
     * @var string Selected value.
     */
    private $Id;

    /**
     * Constructor to load when there is a new object created.
     *
     * @param string $id The unique identifier of the field.
     * @param string $selected The selected radio button.
     */
    public function __construct($id, $selected)
    {
        $this->Id = $id;
        # Store the selected value
        $this->Selected = $selected;
        # Create radio yes selections
        $yes = new Radio($id, 'Y');
        if ($selected === 'Y') {
            $yes->addAttribute('checked', 'checked');
        }
        $this->Yes = $yes;
        # Create radio no selections
        $no = new Radio($id, 'N');
        if ($selected === 'N') {
            $no->addAttribute('checked', 'checked');
        }
        $this->No = $no;
        $this->addAttribute('id', $id);
    }

    public function __toString()
    {
        return $this->createYesNo();
    }

    /**
     * function to created html yesNo
     * @return string
     */
    private function createYesNo(): string
    {

        $result = '';
        $result .= '<div class="icheck-primary d-inline">';
        $result .= $this->Yes;
        $result .= '<label class="check-label" for="' . $this->Id . '_Y">' . trans('global.yes') . '</label>';
        $result .= '</div>';
        $result .= '<div class="icheck-primary d-inline">';
        $result .= $this->No;
        $result .= '<label class="check-label" for="' . $this->Id . '_N">' . trans('global.no') . '</label>';
        $result .= '</div>';
        return $result;
    }

    /**
     * Disable the radio system.
     *
     * @return void
     */
    public function setDisabled(): void
    {
        $this->Yes->addAttribute('disabled', 'disabled');
        $this->No->addAttribute('disabled', 'disabled');
    }

    /**
     * Set readonly for radio system.
     * @param bool $readOnly To store the trigger
     * @return void
     */
    public function setReadOnly(bool $readOnly = true): void
    {
        if ($readOnly === true) {
            if ($this->Selected === 'Y') {
                $this->No->addAttribute('disabled', 'disabled');
            } else {
                $this->Yes->addAttribute('disabled', 'disabled');
            }
        }
    }
}
