<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui;

use App\Frame\Formatter\Trans;
use App\Frame\Gui\Buttons\HyperLink;
use App\Frame\Gui\Buttons\SubmitButton;
use App\Frame\Gui\Fields\YesNo;
use App\Frame\Gui\Labels\LabelYesNo;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Table
{
    /**
     * Attribute id table
     * @var string $TableId
     */
    public $TableId = '';

    /**
     * Attribute prefix
     * @var string $Prefix
     */
    private $Prefix = '';

    /**
     * Attribute prefix
     * @var string $Params
     */
    private $Params = '';

    /**
     * @var Content
     */
    public $Content;
    /**
     * Attribute to store header table
     * @var array $Header
     */
    private $Header = [];

    /**
     * Attribute to store body table
     * @var array $Body
     */
    private $Body = [];

    /**
     * Attribute table
     * @var array $TableAttributes
     */
    private $TableAttributes = [];

    /**
     * Attribute title table
     * @var string $Title
     */
    public $Title = '';

    public $ColumnAttributes = [];

    public $Form = '';

    /**
     * Attribute button view
     * @var bool $View
     */
    public $BtnView = false;
    /**
     * Attribute button view
     * @var bool $BtnEdit
     */
    public $BtnEdit = true;
    /**
     * Attribute button view
     * @var bool $BtnSwitch
     */
    public $BtnSwitch = false;
    /**
     * Attribute button view
     * @var bool $BtnSwitch
     */
    public $BtnNew = true;
    /**
     * Attribute button action
     * @var bool $BtnAction
     */
    public $BtnAction = true;
    /**
     * Attribute button action
     * @var array $Button
     */
    public $Button = [];
    /**
     * Attribute id
     * @var int $Id
     */
    public $Id;

    public function __construct(string $tableId)
    {
        $this->TableId = $tableId;
        $this->Content = new Content();
        $this->addTableAttribute('id', $tableId);
        $this->addTableAttribute('class', 'table table-bordered table-hover');
    }

    /**
     * Add extra attributes to the table property.
     *
     * @param string $attributeName The attribute name.
     * @param string $value The attribute value.
     *
     * @return void
     */
    public function addTableAttribute($attributeName, $value): void
    {
        $this->TableAttributes[$attributeName] = $value;
    }

    /**
     * Returns the complete string with all the table attributes that are added via the object or via internal use of
     * the class.
     *
     * @return string list with all table attributes
     */
    private function getTableAttributes(): string
    {
        $attr = '';
        # Gets complete list with all table attributes
        foreach ($this->TableAttributes as $key => $value) {
            # Concatenate to one string line
            $attr .= ' ' . $key . '="' . $value . '"';
        }

        return $attr;
    }

    /**
     * function to get title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->Title;
    }

    /**
     * function to create table
     * @return string
     */
    public function viewTable(): string
    {
        $view = '';
        if (!empty($this->Header)) {
            $header = $this->Content->cardHeader($this->Title);
            $view .= $this->Content->contentHeader($this->getTitle(), $this->loadDefaultButton());
            $card = $this->Content->card($header, $this->createTable());
            $view .= $this->Content->content($card, $this->Form);
        }
        return $view;
    }

    public function createTable(): string
    {
        $table = '<div class="card-body">';
        $table .= '<table ' . $this->getTableAttributes() . '> ';
        $table .= $this->getHeader();
        $table .= $this->getBody();
        $table .= '</table>';
        $table .= '</div>';
        return $table;
    }

    public function loadDefaultButton(): string
    {
//        $button = $this->getButtonSearch();
        $button = '&nbsp';
        if ($this->BtnNew === true) {
            $url = url($this->Prefix . "/detail");
            if (!empty($this->Id)) {
                $url = url($this->Prefix . "/detail?us_id=" . $this->Id);
            }
            $new = new HyperLink('btnNew', Trans::getWord('new'), $url);
            $new->viewAsHyperlink();
            $button .= $new->setIcon('fa-plus')->btnInfo()->btnMedium();
        }
        return $button;
    }

    /**
     * function to get body
     * @return string
     */
    public function getBody(): string
    {
        $rows = $this->getTbody();
        return '<tbody id="' . $this->TableId . '_body">' . $rows . '</tbody>';
    }

    /**
     * function to get tbody
     * @return string
     */
    public function getTbody(): string
    {
        $tbody = '';
        $no = 1;
        foreach ($this->getRows() as $row) {
            $tbody .= '<tr>';
            $tbody .= '<td>' . $no++ . '</td>';

            foreach ($this->Header as $key => $value) {
                $tbody .= '<td ' . $this->getColumnAttributes($key) . '>' . $this->doPrepareColumnType($row[$key]) . '</td>';
            }
            if ($this->BtnSwitch === true) {
                $tbody .= '<td style="text-align: center">' . $this->getAction($row[$this->Prefix . '_ss_id']) . '</td>';
            } elseif ($this->BtnAction === true) {
                $tbody .= '<td style="text-align: center">' . $this->getAction($row[$this->Params]) . '</td>';
            } else {
                $tbody .= '';
            }
            $tbody .= '</tr>';
        }
        return $tbody;
    }

    /**
     * Add extra attributes to the columns of the table to create.
     *
     * @param string $columnId The column identifier.
     * @param string $attributeName The attribute name.
     * @param string $value The attribute value.
     *
     * @return void
     */
    public function addColumnAttribute($columnId, $attributeName, $value): void
    {
        $this->ColumnAttributes[$columnId][$attributeName] = $value;
    }

    /**
     * Return the complete attribute listing.
     *
     * @param string $columnId The column identifier.
     *
     * @return string
     */
    private function getColumnAttributes($columnId): string
    {
        $attr = '';
        # Check if the column attribute is set
        if (array_key_exists($columnId, $this->ColumnAttributes) === true) {
            # get all attribute for one column
            $attributes = $this->ColumnAttributes[$columnId];
            foreach ($attributes as $key => $value) {
                $attr .= ' ' . $key . '="' . $value . '"';
            }
        }

        # Return the complete attribute listing
        return $attr;
    }

    /**
     * @param $value
     * @return string
     */
    public function doPrepareColumnType($value): string
    {
        if ($value === "Y" || $value === "N") {
            $result = new LabelYesNo($value);
        } elseif ($value === null) {
            $result = '-';
        } else {
            $result = $value;
        }
        return $result;
    }

    /**
     * Function to get all the rows in table.
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->Body;
    }

    /**
     * function to button action
     * @param int $id
     * @return string
     */
    private function getAction(int $id): string
    {
        $button = '';
        if ($this->BtnEdit === true) {
            $edit = new HyperLink('btnEdit','', url($this->Prefix . '/detail?' . $this->Prefix . '_id=' . $id));
            $edit->viewAsHyperlink();
            $button = $edit->setIcon('fa-pencil-alt')->btnPrimary();
        }
        if ($this->BtnView === true) {
            $button .= '&nbsp';
            $view  = new HyperLink('btnView','', url($this->Prefix . '/view?' . $this->Params . '=' . $id));
            $view->viewAsHyperlink();
            $button .= $view->setIcon('fa-eye')->btnInfo();
        }
        if ($this->BtnSwitch === true) {
            $button .= '&nbsp';
            $switch = new HyperLink('btnSwitch','', route('/doSwitchSystem', $id));
            $switch->viewAsHyperlink();
            $button .= $switch->setIcon('fa-sign-in-alt')->btnPrimary();
        }
        return $button;
    }

    private function getButtonSearch(): string
    {
        $button = new SubmitButton('btnSearch',Trans::getWord('search'));
        $button->setIcon('fa-search')->btnSuccess();
        return $button;
    }

    /**
     * function to get header table
     * @return string
     */
    public function getHeader(): string
    {
        $header = '<thead>';
        $header .= '<tr style="background-color: #2E4053;">';
        $header .= '<th style="color: #ecf0f1;">#</th>';
        foreach ($this->Header as $key => $value) {
            $header .= '<th style="color: #ecf0f1;">' . $value . '</th>';
        }
        if ($this->BtnAction === true) {
            $header .= '<th style="color: #ecf0f1;">Action</th>';
        }
        $header .= '</tr>';
        $header .= '</thead>';
        return $header;
    }

    /**
     * function to script data table
     * @return string
     */
    public function scriptTable(): string
    {
        $script = '<script>';
        $script .= '$(function () {';
        $script .= '$("#' . $this->TableId . '").DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": false,
                "searching": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });';
        $script .= '});';
        $script .= '</script>';
        return $script;
    }

    /**
     * @param $prefix
     * @return string
     */
    public function setPrefix($prefix): string
    {
        return $this->Prefix = $prefix;
    }

    /**
     * function to set button new
     * @param bool $button
     */
    public function setEnableButtonNew($button = true): void
    {
        $this->BtnNew = $button;
    }

    /**
     * function to set button view
     * @param string $params
     */
    public function setEnableButtonView(string $params = ''): void
    {
        $this->BtnView = true;
        $this->Params = $params;
    }

    /**
     * function to set button edit
     * @param bool $button
     * @param string $params
     */
    public function setEnableButtonEdit($button = true, string $params = ''): void
    {
        $this->BtnEdit = $button;
        $this->Params = $params;
    }

    /**
     * function to set button switch
     * @param bool $button
     */
    public function setEnableButtonSwitch($button = true): void
    {
        $this->BtnSwitch = $button;
    }

    public function setUserId(int $id): void
    {
        $this->Id = $id;
    }

    /**
     * function load button
     * @param $name
     * @param $button
     * @return string
     */
    public function setLoadButton($name, $button): string
    {
        return $this->Button[$name] = $button . '&nbsp';
    }


    /**
     * function to set header table
     * @param array $headerData store data header
     * @return array
     */
    public function setHeader(array $headerData): array
    {
        return $this->Header = $headerData;
    }

    /**
     * Add a single row to the body array.
     *
     * @param array $data Add a single row to the body of the table.
     *
     * @return void
     */
    public function setRows(array $data): void
    {
        $this->Body = $data;
    }

    /**
     * function to set title table
     * @param $title
     * @return string
     */
    public function setTitle($title): string
    {
        return $this->Title = $title;
    }

    public function setForm($form): void
    {
        $this->Form = $form;
    }

    /**
     * set btn action
     * @param bool $button
     */
    public function setEnableBtnAction($button = true): void
    {
        $this->BtnAction = $button;
    }
}
