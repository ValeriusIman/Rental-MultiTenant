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
use App\Frame\Gui\FieldSet;
use App\Frame\Gui\Table;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Mvc
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
abstract class AbstractListingModel extends AbstractBaseModel
{

    /**
     * Attribute to store the view action.
     *
     * @var array $TableId
     */
    protected $TableId = '';

    /**
     * Attribute to store the view action.
     *
     * @var array $TableId
     */
    protected $Prefix = '';

    /**
     * Attribute store data body
     *
     * @var array $Body
     */
    protected $Body = [];

    /**
     * @var string $Title
     */
    public $Title = '';

    /**
     * @var Table
     */
    public $Table;

    /**
     * @var FieldSet
     */
    protected $ListingForm;

    /**
     * attribute store attribute form
     * @var array $FormAttributes store attribute
     */
    private $FormAttributes = [];

    /**
     * AbstractListingModel constructor.
     * @param string $prefix
     * @param string $tableId
     */
    public function __construct(string $prefix, string $tableId)
    {
        parent::__construct();
        $this->Prefix = $prefix;
        $this->TableId = $tableId;
        $this->Title = Trans::getWord($tableId);
        $this->Table = new Table($tableId);
        $this->ListingForm = new FieldSet();
        $this->Table->setPrefix($prefix);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->createViewTable();
    }

    /**
     * Abstract function to load the header.
     *
     * @return void
     */
    abstract public function loadResultTable(): void;

    /**
     * Abstract function to load the data.
     *
     * @return array
     */
    abstract public function loadData(): array;

    /**
     * function to create table
     * @return string
     */
    public function createViewTable(): string
    {
        return $this->Table->viewTable();
    }

    protected function addForm(array $form): string
    {
        return implode($form);
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
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });';
        $script .= '});';
        $script .= '</script>';
        return $script;
    }
}
