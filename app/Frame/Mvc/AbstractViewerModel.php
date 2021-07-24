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
use App\Frame\Gui\Buttons\Button;
use App\Frame\Gui\Buttons\HyperLink;
use App\Frame\Gui\Content;
use App\Frame\Gui\Validation\Validation;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Mvc
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
abstract class AbstractViewerModel extends AbstractDetailModel
{

    public $View = [];
    public $Title = '';
    private $Label = '';
    private $Params;
    public $BtnFinish = false;
    public $Content;
    public $Validation;
    private $FormAttributes = [];

    /**
     * attribute store prefix
     * @var string $Prefix store prefix
     */
    public $Prefix = '';

    /**
     * AbstractViewerModel constructor.
     * @param string $prefix
     * @param string $detailReferenceCode
     */
    public function __construct(string $prefix, string $detailReferenceCode)
    {
        parent::__construct($detailReferenceCode);
        $this->Prefix = $prefix;
        $this->Content = new Content();
        $this->Validation = new Validation();
        $this->addFormAttribute('id', 'main_form');
        $this->addFormAttribute('class', 'form-horizontal');
        $this->addFormAttribute('method', 'POST');
        $this->addFormAttribute('enctype', 'multipart/form-data');
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
     * @param string $title
     */
    protected function setTitle(string $title): void
    {
        $this->Title = $title;
    }

    /**
     * @param bool $button
     */
    protected function setEnableBtnFinish($button = true): void
    {
        $this->BtnFinish = $button;
    }

    /**
     * @param string $params
     */
    protected function setParams(string $params): void
    {
        $this->Params = $params;
    }

    /**
     * @param $title
     */
    protected function setLabel($title): void
    {
        $this->Label = $title;
    }

    /**
     * Function to do the insert of the transaction.;
     * @return int|null
     */
    public function doInsert(): ?int
    {
        return 0;
    }

    /**
     * function to set portlet
     * @param $title
     * @param $view
     */
    public function setView($title, $view): void
    {
        $this->View[$title] = $view;
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
     * function to load create view
     * @return string
     */
    public function createView(): string
    {
//        dd(implode($this->View));
        $view = '';
//        $url = '';
        if ($this->isUpdate() === true) {
            $url = url("/" . $this->Prefix . "/view?" . $this->Params . "=" . $this->getDetailReferenceValue());
            $view .= '<form ' . $this->getFormAttributes() . ' action="' . $url . '">';
        }
        $view .= csrf_field();
        $view .= $this->Content->contentHeader('#' . $this->Label, $this->loadDefaultButton());
        $view .= $this->Content->content(implode($this->View), $this->loadMessageBox());
        $view .= '</form>';
        return $view;
    }

    /**
     * function button save and close
     * @return string
     */
    private function loadDefaultButton(): string
    {
        $button = '';
        if ($this->BtnFinish === true) {
            $finish = new Button('btnFinish', Trans::getWord('finish'));
            $button .= $finish->setIcon('fa-check-circle')->btnPrimary()->btnSubmit();
        }
        $button .= '&nbsp';
        $close = new HyperLink('btnClose', Trans::getWord('close'), url($this->Prefix));
        $button .= $close->setIcon('fa-arrow-circle-left')->btnDanger();
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


    /**
     * function to insert and update ajax
     * @return string
     */
    public function ajax(): string
    {
        $ajax = 'let form = $("#' . $this->FormAttributes['id'] . '")[0];';
        $ajax .= 'let data = new FormData(form);';
        $ajax .= '$.ajax({type: "POST",enctype: "multipart/form-data",';
//        if ($this->isUpdate()) {
        $ajax .= 'url: "' . url("/" . $this->Prefix . "/view?" . $this->Params . "=" . $this->getDetailReferenceValue()) . '",';
//        }
        $ajax .= 'data: data,processData: false,contentType: false,cache: false,timeout: 600000,';
        $ajax .= 'success: function(data) {';
//        $ajax .= 'swal({title: "success",type: "success"})';
//        $ajax .= '.then(function(){window.location.href = "' . url("/" . $this->Prefix . "/listing") . '";})';
        $ajax .= '}});';

        return $ajax;
    }
}
