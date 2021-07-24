<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Dao\Master;

use App\Frame\Mvc\AbstractBaseDao;
use App\Frame\Formatter\DataParser;
use Illuminate\Support\Facades\DB;

/**
 * Class to handle data access object for table sepeda_motor.
 *
 * @package    app
 * @subpackage Models\Dao\Master
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class SepedaMotorDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'sp_id',
        'sp_as_id',
        'sp_warna_id',
        'sp_type_id',
        'sp_status_id',
        'sp_bahan_bakar',
        'sp_brand',
        'sp_variant',
        'sp_tahun_pembuatan',
        'sp_harga',
        'sp_cc',
        'sp_type_injeksi',
        'sp_kapasitas_tangki',
        'sp_transmisi',
        'sp_stnk',
        'sp_bpkb',
        'sp_active',
    ];

    /**
     * Base dao constructor for sepeda_motor.
     *
     */
    public function __construct()
    {
        parent::__construct('sepeda_motor', 'sp', self::$Fields);
    }

    /**
     * function to get all available fields
     *
     * @return array
     */
    public static function getFields(): array
    {
        return self::$Fields;
    }

    /**
     * Function to get data by reference value
     *
     * @param int $referenceValue To store the reference value of the table.
     *
     * @return array
     */
    public static function getByReference($referenceValue): array
    {
        $wheres = [];
        $wheres[] = '(sp.sp_id = ' . $referenceValue . ')';
        $data = self::loadData($wheres);
        if (count($data) === 1) {
            return $data[0];
        }
        return [];
    }

    /**
     * Function to get data by reference value
     *
     * @param int $referenceValue To store the reference value of the table.
     *
     * @return array
     */
    public static function getPriceByAssetId($referenceValue): array
    {
        $wheres = [];
        $wheres[] = '(sp.sp_as_id = ' . $referenceValue . ')';
        $data = self::loadData($wheres);
        if (count($data) === 1) {
            return $data[0];
        }
        return [];
    }

    /**
     * Function to get data by reference value
     *
     * @param int $referenceValue To store the reference value of the table.
     * @param int $ssId To store the system setting value.
     *
     * @return array
     */
    public static function getByReferenceAndSystem($referenceValue, $ssId): array
    {
        $wheres = [];
        $wheres[] = '(sp.sp_id = ' . $referenceValue . ')';
        $wheres[] = '(sp_ss_id = ' . $ssId . ')';
        $data = self::loadData($wheres);
        if (count($data) === 1) {
            return $data[0];
        }
        return [];
    }

    /**
     * Function to get all record.
     *
     * @param array $wheres To store the list condition query.
     * @param array $orders To store the list sorting query.
     * @param int $limit To store the limit of the data.
     * @param int $offset To store the offset of the data to apply limit.
     *
     * @return array
     */
    public static function loadData(array $wheres = [], array $orders = [], int $limit = 0, int $offset = 0): array
    {
        $strWhere = '';
        if (empty($wheres) === false) {
            $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        }
        $query = 'SELECT sp.sp_id, sp.sp_as_id, sp.sp_warna_id, sp.sp_type_id, sp.sp_status_id, sp.sp_bahan_bakar,
                         sp.sp_brand, sp.sp_variant, sp.sp_tahun_pembuatan, sp.sp_harga, sp.sp_cc, sp.sp_type_injeksi,
                         sp.sp_kapasitas_tangki, sp.sp_transmisi, sp.sp_stnk, sp.sp_bpkb, sp.sp_active, sty1.sty_name as sp_type_name,
                         ass.as_code as sp_as_code, sty2.sty_name as sp_status_name, sty3.sty_name as sp_warna
                        FROM sepeda_motor as sp
                        INNER JOIN asset as ass on ass.as_id = sp.sp_as_id
                        INNER JOIN system_type as sty1 on sty1.sty_id = sp.sp_type_id
                        INNER JOIN system_type as sty2 on sty2.sty_id = sp.sp_status_id
                        INNER JOIN system_type as sty3 on sty3.sty_id = sp.sp_warna_id' . $strWhere;
        if (empty($orders) === false) {
            $query .= ' ORDER BY ' . implode(', ', $orders);
        }
        if ($limit > 0) {
            $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        }
        $sqlResults = DB::select($query);

        return DataParser::arrayObjectToArray($sqlResults);
    }

}
