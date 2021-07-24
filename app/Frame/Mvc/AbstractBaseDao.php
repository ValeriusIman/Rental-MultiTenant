<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Mvc;

use App\Frame\Exceptions\Message;
use App\Frame\Formatter\StringFormatter;
use App\Frame\System\Session\UserSession;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Mvc
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class AbstractBaseDao extends Model
{
    /**
     * Property to store the prefix of the table.
     *
     * @var string
     */
    protected $TablePrefix = '';


    /**
     * Property to store the last insert id.
     *
     * @var int
     */
    protected $LastInsertId = 0;

    /**
     * Original object from Uploaded File class.
     *
     * @var UploadedFile $File
     */
    protected $File;

    /**
     * Property to store the incremental number.
     *
     * @var int
     */
    protected $Incremental = 0;


    /**
     * Base dao constructor.
     *
     * @param string $tableName To store the name of the table.
     * @param string $prefixTable To store the prefix of the table.
     * @param array $fields To store the field list for the table.
     */
    public function __construct(string $tableName = '', string $prefixTable = '', array $fields = [])
    {
        parent::__construct();
        $this->timestamps = false;
        $this->TablePrefix = $prefixTable;
        $this->table = $tableName;
        $this->primaryKey = $prefixTable . '_id';
        $this->initializeRandomIncremental();
        if (empty($fields) === false) {
            $fillAble = [];
            foreach ($fields as $field) {
                if ($field !== $this->primaryKey) {
                    $fillAble[] = $field;
                }
            }
            $fillAble = array_merge($fillAble, [
                $this->TablePrefix . '_created_on',
                $this->TablePrefix . '_updated_on',
                $this->TablePrefix . '_deleted_on',
                $this->TablePrefix . '_deleted_by',
            ]);
            $this->fillable = array_values(array_unique($fillAble));
        }
    }

    /**
     * Function to initialize random incremental.
     *
     * @return void
     */
    private function initializeRandomIncremental(): void
    {
        try {
            $this->Incremental = random_int(0, 100);
        } catch (Exception $e) {
            $this->Incremental = 0;
        }
    }

    /**
     * Abstract function to do insert transaction.
     *
     * @param array $fieldData To store the field value per column.
     *
     * @return void
     */
    public function doInsertTransaction(array $fieldData): void
    {
        $this->Incremental++;
        $colValue = array_merge($fieldData, [
            $this->TablePrefix . '_created_on' => date('Y-m-d H:i:s'),
        ]);
        $this->LastInsertId = DB::table($this->table)->insertGetId($colValue, $this->primaryKey);
    }

    /**
     * Abstract function to load the data.
     *
     * @param int $primaryKeyValue To store the primary key value.
     * @param array $fieldData To store the field value per column.
     *
     * @return void
     */
    public function doUpdateTransaction($primaryKeyValue, array $fieldData): void
    {
        $colValue = array_merge($fieldData, [
            $this->TablePrefix . '_updated_on' => date('Y-m-d H:i:s'),
        ]);
        DB::table($this->table)
            ->where($this->primaryKey, $primaryKeyValue)
            ->update($colValue);
    }

    /**
     * Abstract function to load the data.
     *
     * @param int $primaryKeyValue To store the primary key value.
     *
     * @return void
     */
    public function doDeleteTransaction($primaryKeyValue): void
    {
        $user = new UserSession();
        $data = [
            $this->TablePrefix . '_deleted_on' => date('Y-m-d H:i:s'),
            $this->TablePrefix . '_deleted_by' => $user->getId(),
        ];
        DB::table($this->table)
            ->where($this->primaryKey, $primaryKeyValue)
            ->update($data);
    }

    /**
     * Function to set the user detail that do the un-delete.
     *
     * @return int
     */
    public function getLastInsertId(): int
    {
        return $this->LastInsertId;
    }

    /**
     * Set filename to be opened or created.
     *
     * @param UploadedFile $file The filename.
     * @param string $nameSpace The filename.
     * @param string $nameFile The filename.
     *
     * @return void
     */
    public function upload(UploadedFile $file, $nameSpace, $nameFile): void
    {
        if ($file === null) {
            Message::throwMessage('Invalid file object in file class.', 'DEBUG');
        } else {
            $this->File = $file;
            $path = 'public/';
            $path .= mb_strtolower($nameSpace);
            $success = $file->storeAs($path, $nameFile);
            if ($success === false) {
                Message::throwMessage('Failed to upload the file', 'ERROR');
            }
        }
    }

    /**
     * function to delete image
     * @param $logo
     * @param $nameSpace
     */
    public function doDeleteFile($logo,$nameSpace): void
    {
        if ($logo !== null){
            $path = 'app\\public\\';
            $path .= mb_strtolower($nameSpace);
            $path .= '\\';
            $fileLogo = storage_path($path) . $logo;
            if (file_exists($fileLogo)) {
                unlink($fileLogo);
            }
        }
    }

}
