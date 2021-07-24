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
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Mvc
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
abstract class AbstractDetailModel extends AbstractBaseModel
{
    /**
     * attribute store prefix
     * @var string $DetailReferenceCode store prefix
     */
    public $DetailReferenceCode = '';

    /**
     * Property to store the reference value.
     *
     * @var int
     */
    private $DetailReferenceValue = 0;

    /**
     * Property to store the trigger to show insert button.
     *
     * @var boolean $EnableInsertButton
     */
    private $EnableInsertButton = true;

    private $Info = [];
    private $Errors = [];

    /**
     * FieldSet constructor.
     * @param string $detailReferenceCode
     */
    public function __construct(string $detailReferenceCode)
    {
        parent::__construct();
        $this->setDetailReferenceCode($detailReferenceCode);
    }

    /**
     * Function to set the detail reference value.
     *
     * @param string $detailReferenceCode To store the reference code.
     *
     * @return void
     */
    public function setDetailReferenceCode($detailReferenceCode): void
    {
        $this->DetailReferenceCode = $detailReferenceCode;
    }

    /**
     * Function to check is the insert button enable or not.
     *
     * @return bool
     */
    protected function isInsertButtonEnabled(): bool
    {
        return $this->EnableInsertButton;
    }

    /**
     * Function to set disable insert.
     *
     * @param bool $disable To set disable value.
     *
     * @return void
     */
    protected function setDisableInsert(bool $disable = true): void
    {
        $this->EnableInsertButton = true;
        if ($disable === true) {
            $this->EnableInsertButton = false;
        }
    }

    /**
     * Function to do the transaction of database.;
     *
     * @return void
     */
    public function doTransaction(): void
    {
        DB::beginTransaction();
        try {
//            dd($this->isInsert());
            if ($this->isUpdate() === true) {
                $this->doUpdate();
                $this->addSuccessMessage(Trans::getWord('successUpdate', 'message'));
            }
            if ($this->isInsert() === true) {
                $lastInsertId = $this->doInsert();
                $this->setDetailReferenceValue($lastInsertId);
                $log['ul_ref_id'] = $lastInsertId;
                $this->addSuccessMessage(Trans::getWord('successInsert', 'message'));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($this->isUpdate() === true) {
                $this->addErrorsMessage(Trans::getWord('failedUpdate', 'message'));
            }
            if ($this->isInsert() === true) {
                $this->addErrorsMessage(Trans::getWord('failedInsert', 'message'));
            }
            $this->addErrorMessage($this->doPrepareSqlErrorMessage($e->getMessage()));
        }
    }

    /**
     * Function to prepare sql message.
     *
     * @param string $error To store the error message of the sql.
     *
     * @return string
     */
    public function doPrepareSqlErrorMessage(string $error): string
    {
        $message = $error;
        if (strpos($error, 'duplicate') !== false) {
            $indexUniqueWord = strpos($error, '_unique');
            if ($indexUniqueWord !== false) {
                $message = substr($error, 0, $indexUniqueWord + 8) . '.';
                $message = str_replace('"', '', $message);
            }
        }

        return $message;
    }

    /**
     * Function to add success message to the view.
     *
     * @param string $message To store the value of the data.
     *
     * @return void
     */
    public function addSuccessMessage($message): void
    {
        if (empty($message) === false) {
            $this->addInfoMessage($message);
        }
    }

    /**
     * Function to add error message to the view.
     *
     * @param string $message To store the value of the data.
     *
     * @return void
     */
    public function addErrorsMessage($message): void
    {
        if (empty($message) === false) {
            $this->addErrorMessage($message);
        }
    }

    /**
     * Function to add information.
     *
     * @param string $massage To store the data.
     *
     * @return void
     */
    public function addInfoMessage(string $massage): void
    {
        $this->Info[] = $massage;
    }

    /**
     * Function to add error.
     *
     * @param string $massage To store the data.
     *
     * @return void
     */
    public function addErrorMessage(string $massage): void
    {
        $this->Errors[] = $massage;
    }

    /**
     * Function to create the error notification.
     *
     * @return string
     */
    protected function loadMessageBox(): string
    {
        $result = '';
        if (empty($this->Errors) === false) {
            foreach ($this->Errors as $message) {
                $result .= $this->createHtmlMessage($message, 'alert-danger');
            }
        }
        if (empty($this->Warnings) === false) {
            foreach ($this->Warnings as $message) {
                $result .= $this->createHtmlMessage($message, 'alert-warning');
            }
        }
        if (empty($this->Info) === false) {
            foreach ($this->Info as $message) {
                $result .= $this->createHtmlMessage($message, 'alert-success');
            }
        }

        return $result;
    }

    /**
     * Function to create the info notification.
     *
     * @param string $message To store the message.
     * @param string $type    To store the type of the message to set the style of the box.
     *
     * @return string
     */
    private function createHtmlMessage(string $message, string $type = ''): string
    {
        $result = '';
        if (empty($message) === false) {
            $result .= '<div class="alert ' . $type . ' alert-dismissible" role="alert">';
            $result .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
            $result .= $message;
            $result .= '</div>';
        }

        return $result;
    }

    /**
     * Function to get the detail reference value.
     *
     * @return string
     */
    public function getDetailReferenceCode(): string
    {
        return $this->DetailReferenceCode;
    }

    /**
     * Function to get the detail reference value.
     *
     * @return integer
     */
    public function getDetailReferenceValue(): int
    {
        if (empty($this->DetailReferenceValue) === true && empty($this->getDetailReferenceCode()) === false) {
            $this->DetailReferenceValue = (int)$this->getIntParameter($this->getDetailReferenceCode());
        }

        return $this->DetailReferenceValue;
    }

    /**
     * Function to set the detail reference value.
     *
     * @param integer $detailReferenceValue To store the last key value.
     *
     * @return void
     */
    public function setDetailReferenceValue($detailReferenceValue): void
    {
        $this->DetailReferenceValue = $detailReferenceValue;
    }

    /**
     * Function to check is it insert process or not.
     *
     * @return boolean
     */
    public function isInsert(): bool
    {
        $result = false;
        if (empty($this->getDetailReferenceValue()) === true) {
            $result = true;
        }

        return $result;
    }

    /**
     * Function to check is it update process or not.
     *
     * @return boolean
     */
    public function isUpdate(): bool
    {
        $result = false;
        if (empty($this->getDetailReferenceValue()) === false) {
            $result = true;
        }

        return $result;
    }

    /**
     * abstract function field
     */
    abstract public function loadForm(): void;

    /**
     * abstract function to insert
     * @return int|null
     */
    abstract public function doInsert(): ?int;

    /**
     * abstract function to update
     */
    abstract public function doUpdate(): void;

    /**
     * abstract function to load data
     * @return array
     */
    abstract public function loadData(): array;

    /**
     * abstract function to load validation
     */
    abstract public function loadValidation(): void;


}
