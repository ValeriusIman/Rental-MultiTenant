<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Dao\System\Service;

use App\Frame\Mvc\AbstractBaseDao;
use App\Frame\Formatter\DataParser;
use Illuminate\Support\Facades\DB;

/**
 * Class to handle data access object for table system_service.
 *
 * @package    app
 * @subpackage Models\Dao\System\Service
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class SystemServiceDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'ssr_id',
        'ssr_ss_id',
        'ssr_srv_id',
        'ssr_active',
    ];

    /**
     * Base dao constructor for system_service.
     *
     */
    public function __construct()
    {
        parent::__construct('system_service', 'ssr', self::$Fields);
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
        $wheres[] = '(ssr.ssr_id = ' . $referenceValue . ')';
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
        $wheres[] = '(ssr.ssr_id = ' . $referenceValue . ')';
        $wheres[] = '(ssr.ssr_ss_id = ' . $ssId . ')';
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
        $query = 'SELECT ssr.ssr_id, ssr.ssr_ss_id, ssr.ssr_srv_id, ssr.ssr_active,
                        ss.ss_relation as ssr_ss_relation, srv.srv_code as ssr_srv_code,
                        srv.srv_name as ssr_srv_name
                        FROM system_service as ssr
                        LEFT JOIN system_setting as ss on ss.ss_id = ssr.ssr_ss_id
                        LEFT JOIN service as srv on srv.srv_id = ssr.ssr_srv_id' . $strWhere;
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
