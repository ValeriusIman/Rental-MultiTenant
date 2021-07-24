<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Mvc;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\Buttons\HyperLink;
use App\Frame\Gui\Buttons\SubmitButton;
use App\Frame\Gui\Content;
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Table;
use App\Frame\Gui\Validation\Validation;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Mvc
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
abstract class AbstractFormModel extends AbstractDetailModel
{

    /**
     * attribute store prefix
     * @var string $Prefix store prefix
     */
    public $Prefix = '';

    /**
     * @var string $Title
     */
    public $Title = '';

    /**
     * @var Validation
     */
    public $Validation;

    /**
     * attribute store prefix
     * @var string $DetailReferenceCode store prefix
     */
    public $DetailReferenceCode = '';

    /**
     * attribute store attribute form
     * @var array $FormAttributes store attribute
     */
    private $FormAttributes = [];

    /**
     * @var string $View
     */
    public $View = [];

    /**
     * @var Content
     */
    public $Content;

    /**
     * @var Table
     */
    public $Table;

    /**
     * @var $Reload
     */
    private $Url;

    /**
     * @var bool $btnClose
     */
    private $BtnClose = true;

    /**
     * @var bool $btnTransaksi
     */
    public $btnTransaksi = false;

    /**
     * @var int $LastId
     */
    private $Button = [];

    /**
     * FieldSet constructor.
     * @param string $prefix
     * @param string $detailReferenceCode
     */
    public function __construct(string $prefix, string $detailReferenceCode)
    {
        parent::__construct($detailReferenceCode);
        $this->Prefix = $prefix;
        $this->addFormAttribute('id', 'main_form');
        $this->addFormAttribute('class', 'form-horizontal');
        $this->addFormAttribute('method', 'POST');
        $this->addFormAttribute('enctype', 'multipart/form-data');
        $this->Content = new Content();
        $this->Validation = new Validation();
        $this->Table = new Table('');

    }

    protected function setTitle($title): void
    {
        $this->Title = Trans::getWord($title);
    }

    /**
     * Add extra attributes to the table property.
     *
     * @param string $attributeName The attribute name.
     * @param string $value The attribute value.
     *
     * @return void
     */
    public function addFormAttribute($attributeName, $value): void
    {
        $this->FormAttributes[$attributeName] = $value;
    }

    /**
     * Returns the complete string with all the table attributes that are added via the object or via internal use of
     * the class.
     *
     * @return string list with all table attributes
     */
    private function getFormAttributes(): string
    {
        $attr = '';
        # Gets complete list with all table attributes
        foreach ($this->FormAttributes as $key => $value) {
            # Concatenate to one string line
            $attr .= ' ' . $key . '="' . $value . '"';
        }

        return $attr;
    }

    /**
     * function add field in row
     * @param array $field store field
     * @return string
     */
    public function addRow(array $field): string
    {
        return implode($field);
    }

    /**
     * function to set view
     * @param $table
     * @param $portlet
     * @return void
     */
    public function setView($table, $portlet): void
    {
        $this->View[$table] = $portlet;
    }

    public function loadButton($name, $button): string
    {
        return $this->Button[$name] = $button . '&nbsp';
    }

    /**
     * function to set button close
     * @param bool $button
     */
    public function setEnableBtnClose($button = true): void
    {
        $this->BtnClose = $button;
    }

    /**
     * function to set button transaksi
     * @param bool $button
     */
    public function setEnableBtnTransaksi($button = true): void
    {
        $this->btnTransaksi = $button;
    }

    /**
     * function to set button close
     * @param string $url
     */
    public function setUrlBtnClose($url): void
    {
        $this->Url = url('/' . $url);
    }

    /**
     * function to load create view
     * @return string
     */
    public function createView(): string
    {
        $view = '';
        $url = '';
        if ($this->btnTransaksi === true) {
            $url = url("/" . $this->Prefix . "/detail?tr_id=" . $this->getIntParameter('tr_id'));
        }
        if ($this->btnTransaksi === false) {
            if ($this->isInsert() === true) {
                $url = url("/" . $this->Prefix . "/detail");
            }
            if ($this->isUpdate() === true) {
                $url = url("/" . $this->Prefix . "/detail?" . $this->Prefix . "_id=" . $this->getDetailReferenceValue());
            }
        }
        $view .= '<form ' . $this->getFormAttributes() . ' action = "' . $url . '">';
        $view .= csrf_field();
        $view .= $this->Content->contentHeader('Detail of ' . $this->Title, $this->loadDefaultButton());
        $view .= $this->Content->content(implode($this->View), $this->loadMessageBox());
        $view .= '</form>';
        if ($this->isUpdate()) {
            $view .= $this->Table->viewTable();
        }
        return $view;
    }


    /**
     * function button save and close
     * @return string
     */
    public function loadDefaultButton(): string
    {
        $button = '';
        if ($this->btnTransaksi === true) {
            $transaksi = new SubmitButton('btnTransaksi', Trans::getWord('add'));
            $button .= $transaksi->setIcon('fa-plus')->btnPrimary();
        }
        if ($this->btnTransaksi === false) {
            if ($this->isInsert()) {
                $insert = new SubmitButton('btnInsert', Trans::getWord('save'));
                $button .= $insert->setIcon('fa-save')->btnSuccess()->btnSubmit();
            }
            if ($this->isUpdate()) {
                $update = new SubmitButton('btnUpdate', Trans::getWord('update'));
                $button .= $update->setIcon('fa-save')->btnPrimary()->btnSubmit();
            }
        }
        $button .= '&nbsp';
        $button .= implode($this->Button);
        if ($this->BtnClose === true) {
            $url = url($this->Prefix);
            if (!empty($this->Url)) {
                $url = $this->Url;
            }
            $close = new HyperLink('btnClose', Trans::getWord('close'), $url);
            $button .= $close->setIcon('fa-arrow-circle-left')->btnDanger();
        }
        return $button;
    }

    /**
     * function to load script ajax
     * @return string
     */
    public function scriptValidation(): string
    {

        $validation = '<script>';
        $validation .= '$(function() {';
        $validation .= '$(".submit").on("click", function(event) {event.preventDefault();';
        $validation .= 'let validate = $("#' . $this->FormAttributes['id'] . '").valid();';
        $validation .= 'if (validate) {$("#' . $this->FormAttributes['id'] . '").submit();}';
        $validation .= '});';
        $validation .= '$("#' . $this->FormAttributes['id'] . '").validate({';
        $validation .= $this->Validation->getValidation();
        $validation .= $this->Validation->getMassages();
        $validation .= 'errorElement: "span",';
        $validation .= $this->Validation->errorPlacement();
        $validation .= $this->Validation->highlight();
        $validation .= $this->Validation->unhighlight();
        $validation .= '});});';
        $validation .= '</script>';

        return $validation;

    }

}
