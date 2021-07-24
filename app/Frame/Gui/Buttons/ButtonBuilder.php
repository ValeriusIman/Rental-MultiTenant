<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui\Buttons;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\Html\ButtonInterface;
use App\Frame\Gui\Html\Html;

/**
 *
 *
 * @package    app
 * @subpackage Frame/Gui/Buttons
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class ButtonBuilder extends Html implements ButtonInterface
{

    /**
     * Property to store size style
     *
     * @var string $DefaultClass
     */
    protected $DefaultClass = 'btn';
    /**
     * Property to store size style
     *
     * @var string $SizeStyle
     */
    protected $SizeStyle = 'btn-sm';
    /**
     * Property to store color style
     *
     * @var string $ColorStyle
     */
    private $ColorStyle = '';

    /**
     * Property to store position style
     *
     * @var string $PositionStyle
     */
    protected $Submit = '';

    /**
     * Property to store view style
     *
     * @var string $ViewStyle
     */
    private $ViewStyle = '';

    /**
     * Property to store icon button
     *
     * @var string $Icon
     */
    private $Icon = '';

    public function __toString()
    {
        $class = [];
        if (empty($this->DefaultClass) === false) {
            $class[] = $this->DefaultClass;
        }
        if (empty($this->SizeStyle) === false) {
            $class[] = $this->SizeStyle;
        }
        if (empty($this->ColorStyle) === false) {
            $class[] = $this->ColorStyle;
        }
        if (empty($this->ViewStyle) === false) {
            $class[] = $this->ViewStyle;
            $this->setContent('');
        }
        if (empty($this->Submit) === false) {
            $class[] = $this->Submit;
        }
        $content = $this->getIcon() . $this->getContent();
        $this->setContent(trim($content));
        $this->addAttribute('class', implode(' ', $class));
        return parent::__toString();
    }

    public function button(): Button
    {
        return new Button('a', 'a');
    }

    public function HyperLink(): HyperLink
    {
        return new HyperLink('a', 'a', '');
    }

    public function SubmitButton(): SubmitButton
    {
        return new SubmitButton('btnFinish',Trans::getWord('finish'));
    }

    /**
     * function to set icon
     * @param $icon
     * @return self
     */
    public function setIcon($icon): self
    {
        $this->Icon = $icon;
        return $this;
    }

    /**
     * function to get icon
     * @return string
     */
    public function getIcon(): string
    {
        return '<i class="fas ' . $this->Icon . '"></i>&nbsp;';
    }


    /**
     * Function to show button with icon only.
     *
     * @param bool $trigger To trigger if its only show icon or not.
     *
     * @return Button
     */
    public function viewIconOnly(bool $trigger = true): self
    {
        $this->ViewStyle = '';
        if ($trigger === true) {
            $this->ViewStyle = 'btn-icon-only';
        }
        return $this;
    }

    /**
     * Function to set button as large size.
     *
     * @return self
     */
    public function btnLarge(): self
    {
        $this->SizeStyle = 'btn-lg';
        return $this;
    }

    /**
     * Function to set button as medium size.
     *
     * @return self
     */
    public function btnMedium(): self
    {
        $this->SizeStyle = 'btn-sm';
        return $this;
    }

    /**
     * Function to set button as small size.
     *
     * @return self
     */
    public function btnSmall(): self
    {
        $this->SizeStyle = 'btn-xs';
        return $this;
    }

    /**
     * Function to pull position button on right side.
     *
     * @return self
     */
    public function btnSubmit(): self
    {
        $this->Submit = 'submit';
        return $this;
    }

    /**
     * Function to set button color to danger.
     *
     * @return self
     */
    public function btnDanger(): self
    {
        $this->ColorStyle = 'btn-danger';
        return $this;
    }

    /**
     * Function to set button color to primary.
     *
     * @return self
     */
    public function btnPrimary(): self
    {
        $this->ColorStyle = 'btn-primary';
        return $this;
    }

    /**
     * Function to set button color to success.
     *
     * @return self
     */
    public function btnSuccess(): self
    {
        $this->ColorStyle = 'btn-success';
        return $this;
    }

    /**
     * Function to set button color to info.
     *
     * @return self
     */
    public function btnInfo(): self
    {
        $this->ColorStyle = 'btn-info';
        return $this;
    }

    /**
     * Function to set button color to dark.
     *
     * @return self
     */
    public function btnDark(): self
    {
        $this->ColorStyle = 'btn-dark';
        return $this;
    }

    /**
     * Function to set button color to warning.
     *
     * @return self
     */
    public function btnWarning(): self
    {
        $this->ColorStyle = 'btn-warning';
        return $this;
    }

    /**
     * Function to set button color to aqua.
     *
     * @return self
     */
    public function btnAqua(): self
    {
        $this->ColorStyle = 'btn-aqua';
        return $this;
    }

    /**
     * Function to set button color to aqua.
     *
     * @return self
     */
    public function btnDefault(): self
    {
        $this->ColorStyle = 'btn-default';
        return $this;
    }
}
