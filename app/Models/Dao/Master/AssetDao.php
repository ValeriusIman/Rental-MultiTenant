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
 * Class to handle data access object for table asset.
 *
 * @package    app
 * @subpackage Models\Dao\Master
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class AssetDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'as_id',
        'as_ss_id',
        'as_srv_id',
        'as_code',
        'as_active',
    ];

    /**
     * Base dao constructor for asset.
     *
     */
    public function __construct()
    {
        parent::__construct('asset', 'as', self::$Fields);
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
        $wheres[] = '(ass.as_id = ' . $referenceValue . ')';
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
        $wheres[] = '(ass.as_id = ' . $referenceValue . ')';
        $wheres[] = '(ass.as_ss_id = ' . $ssId . ')';
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
        $query = 'SELECT ass.as_id, ass.as_ss_id, ass.as_srv_id, ass.as_code, ass.as_active,
                        srv.srv_name as as_srv_name, mb.mb_brand, mb.mb_variant, mb.mb_price,
                        mb.mb_status_id
                        FROM asset as ass
                        INNER JOIN service as srv on srv.srv_id = ass.as_srv_id
                        LEFT JOIN mobil as mb on ass.as_id = mb.mb_as_id
                        LEFT JOIN system_type as st on mb.mb_status_id = st.sty_id' . $strWhere;
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
