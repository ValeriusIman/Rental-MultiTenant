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
 * Class to handle data access object for table mobil.
 *
 * @package    app
 * @subpackage Models\Dao\Master
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class MobilDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'mb_id',
        'mb_as_id',
        'mb_color_id',
        'mb_fty_id',
        'mb_type_id',
        'mb_brand',
        'mb_variant',
        'mb_build_year',
        'mb_price',
        'mb_cc',
        'mb_status',
        'mb_transmisi',
        'mb_girboks',
        'mb_stnk',
        'mb_bpkb',
        'mb_pintu',
        'mb_seat',
        'mb_height',
        'mb_length',
        'mb_width',
        'mb_tenaga',
        'mb_power_steering',
        'mb_ac',
        'mb_kursi_lipat',
        'mb_abs',
        'mb_kamera_belakang',
        'mb_sabuk_pengaman',
        'mb_airbag_penumpang',
        'mb_airbag_pengemudi',
        'mb_active',
    ];

    /**
     * Base dao constructor for mobil.
     *
     */
    public function __construct()
    {
        parent::__construct('mobil', 'mb', self::$Fields);
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
        $wheres[] = '(mb.mb_id = ' . $referenceValue . ')';
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
        $wheres[] = '(mb.mb_as_id = ' . $referenceValue . ')';
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
        $wheres[] = '(mb.mb_id = ' . $referenceValue . ')';
        $wheres[] = '(mb.mb_ss_id = ' . $ssId . ')';
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
        $query = 'SELECT mb.mb_id, mb.mb_as_id, mb.mb_color_id, mb.mb_fty_id, mb.mb_type_id, mb.mb_brand,
                        mb.mb_variant, mb.mb_built_year, mb.mb_price, mb.mb_cc, mb.mb_status_id, mb.mb_transmisi,
                        mb.mb_girboks, mb.mb_stnk, mb.mb_bpkb, mb.mb_pintu, mb.mb_seat, mb.mb_height, mb.mb_length,
                        mb.mb_width, mb.mb_tenaga, mb.mb_power_steering, mb.mb_ac, mb.mb_kursi_lipat, mb.mb_abs,
                        mb.mb_kamera_belakang, mb.mb_sabuk_pengaman, mb.mb_airbag_penumpang, mb.mb_airbag_pengemudi,
                        ass.as_ss_id as mb_as_ss_id, mb.mb_deleted_on, sty1.sty_name as mb_sty_color, sty2.sty_name as mb_fty_name,
                        sty3.sty_name as mb_sty_type, mb.mb_active, ass.as_code as mb_as_code, sty4.sty_name as mb_status,
                        sty4.sty_id, ass.as_code
                        FROM mobil as mb
                        INNER JOIN asset as ass on ass.as_id = mb.mb_as_id
                        INNER JOIN system_type as sty1 on sty1.sty_id = mb.mb_color_id
                        INNER JOIN system_type as sty2 on sty2.sty_id = mb.mb_fty_id
                        INNER JOIN system_type as sty3 on sty3.sty_id = mb.mb_type_id
                        INNER JOIN system_type as sty4 on sty4.sty_id =mb.mb_status_id' . $strWhere;
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
