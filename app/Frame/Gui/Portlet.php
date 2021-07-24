<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui;

use App\Frame\Exceptions\Message;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Portlet
{
    /**
     * @var array $PortletAttributes
     */
    private $PortletAttributes = [];

    /**
     * @var array $BodyAttributes
     */
    private $BodyAttributes = [];

    /**
     * @var array $HeaderAttributes
     */
    private $HeaderAttributes = [];

    /**
     * @var string $Title
     */
    private $Title = '';

    /**
     * @var string $ColumnGridClass
     */
    public $ColumnGridClass = '';

    /**
     * @var array $Field
     */
    public $Body = [];

    /**
     * Portlet constructor.
     * @param string $portletId
     * @param string $portletTitle
     */
    public function __construct(string $portletId, string $portletTitle = '')
    {
        if (empty($portletId) === false) {
            $this->addPortletAttribute('id', $portletId);
        } else {
            Message::throwMessage('Invalid id for portlet.');
        }
        $this->addPortletAttribute('class', 'card');
        if (empty($portletTitle) === false) {
            $this->Title = $portletTitle;
        }
        $this->addBodyAttribute('id', $portletId . '_content');
        $this->addBodyAttribute('class', 'card-body');
    }

    /**
     * Function to add the portlet attribute.
     *
     * @param string $attributeName To set the attribute name.
     * @param string $attributeValue To set the attribute value.
     *
     * @return void
     */
    public function addPortletAttribute(string $attributeName, string $attributeValue): void
    {
        $this->PortletAttributes[$attributeName] = $attributeValue;
    }

    /**
     * Function to add the body attribute.
     *
     * @param string $attributeName To set the attribute name.
     * @param string $attributeValue To set the attribute value.
     *
     * @return void
     */
    public function addBodyAttribute(string $attributeName, string $attributeValue): void
    {
        $this->BodyAttributes[$attributeName] = $attributeValue;
    }

    /**
     * Function to add the header attribute.
     *
     * @param string $attributeName To set the attribute name.
     * @param string $attributeValue To set the attribute value.
     *
     * @return void
     */
    public function addHeaderAttribute(string $attributeName, string $attributeValue): void
    {
        $this->HeaderAttributes[$attributeName] = $attributeValue;
    }

    /**
     * Function to get the id of the portlet.
     *
     * @return string
     */
    public function getPortletId(): string
    {
        return $this->PortletAttributes['id'];
    }

    /**
     * Function to add the portlet attribute.
     *
     * @param integer $large To set the grid amount for a large screen.
     * @param integer $medium To set the grid amount for a medium screen.
     * @param integer $small To set the grid amount for a small screen.
     * @param integer $extraSmall To set the grid amount for a extra small screen.
     *
     * @return void
     */
    public function setGridDimension(int $large = 3, int $medium = 4, int $small = 6, $extraSmall = 12): void
    {
        $this->ColumnGridClass = 'col-lg-' . $large . ' col-md-' . $medium . ' col-sm-' . $small . ' col-xs-' . $extraSmall;
    }

    /**
     * Function to get portlet attribute.
     *
     * @return string
     */
    private function getPortletAttribute(): string
    {
        $result = ' ';
        if (empty($this->PortletAttributes) === false) {
            foreach ($this->PortletAttributes as $key => $value) {
                $result .= $key . '="' . $value . '"';
            }
        }

        return $result;
    }

    /**
     * Function to get header attribute.
     *
     * @return string
     */
    private function getHeaderAttribute(): string
    {
        $result = ' ';
        if (empty($this->HeaderAttributes) === false) {
            foreach ($this->HeaderAttributes as $key => $value) {
                $result .= $key . '="' . $value . '"';
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->createPortlet();
    }

    /**
     * Function to create the portlet.
     *
     * @return string
     */
    public function createPortlet(): string
    {
        if (empty($this->Title) === false) {
            $this->addHeaderAttribute('class', 'card-header');
        }
        $result = '<div id="' . $this->getPortletId() . 'grid" class="' . $this->ColumnGridClass . '">';
        $result .= '<div ' . $this->getPortletAttribute() . '>';
        $result .= $this->getPortletHeader();
        $result .= $this->getPortletBody();
        $result .= '</div>';
        $result .= '</div>';

        return $result;
    }

    /**
     * @return string
     */
    public function getPortletHeader(): string
    {
        $result = '';
        $result .= '<div ' . $this->getHeaderAttribute() . '>';
        $result .= '<h3 class="card-title">' . $this->Title . '</h3>';
        $result .= '</div>';

        return $result;
    }

    /**
     * @return string
     */
    public function getPortletBody(): string
    {
        $result = '';
        $result .= '<div class="row col-lg">';
        $result .= $this->Body;
        $result .= '</div>';

        return $result;
    }

    /**
     * @param $field
     * @return string
     */
    public function addFieldSet($field): string
    {
        return $this->Body = $field;
    }

    /**
     * @param $field
     * @return void
     */
    public function addText($field): void
    {
        $this->Body = $field;
    }

    /**
     * Function to add the table to the body.
     *
     * @param $table
     *
     * @return void
     */
    public function addTable($table): void
    {
        if ($table !== null) {
            $this->Body = implode($table);
        }
    }
}
