<?php

namespace App\Models\Dao\User;

use App\Frame\Formatter\DataParser;
use App\Frame\Mvc\AbstractBaseDao;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class UserMappingDao extends AbstractBaseDao
{

    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'ump_id',
        'ump_us_id',
        'ump_ss_id',
        'ump_default',
        'ump_active',
        'ump_level',
    ];

    public function __construct()
    {
        parent::__construct('user_mapping', 'ump', self::$Fields);
    }

    /**
     * @param int $userId
     * @param int $ssId
     * @return array
     */
    public static function loadAllUserMappingData(int $userId, $ssId = 0): array
    {
        $wheres = [];
        $wheres[] = '(ump.ump_ss_id <> ' . $ssId . ')';
        $wheres[] = '(ump.ump_us_id = ' . $userId . ')';
        $wheres[] = '(ump.ump_deleted_on IS NULL)';
        $wheres[] = "(ss.ss_active = 'Y')";
        $wheres[] = '(ss.ss_deleted_on IS NULL)';

        return self::loadData($wheres);
    }

    /**
     * function to get all available fields
     *
     * @param int $ssId To Store the id of the system setting.
     *
     * @return array
     */
    public static function loadSystemMappingData(int $ssId = 0): array
    {
        $wheres = [];
        if (is_numeric($ssId) === true && $ssId !== 0 && $ssId > 0) {
            $wheres[] = '(ss.ss_id = ' . $ssId . ')';
        } else {
            $wheres[] = "(ss.ss_system = 'Y')";
        }
        $wheres[] = "(ss.ss_active = 'Y')";
        $wheres[] = '(ss.ss_deleted_on IS NULL)';
        $data = self::loadData($wheres);

        return $data[0];
    }

    /**
     * function to get all available fields
     *
     * @param int $userId To Store the user data.
     * @param int $ssId To Store the user data.
     *
     * @return array
     */
    public static function loadUserMappingData(int $userId, $ssId = 0): array
    {
        $wheres = [];
        $wheres[] = '(ump.ump_us_id = ' . $userId . ')';
        if (is_numeric($ssId) === true && $ssId !== 0 && $ssId > 0) {
            $wheres[] = '(ss.ss_id = ' . $ssId . ')';
        }
        $wheres[] = '(ump.ump_us_id = ' . $userId . ')';
        $wheres[] = "(ump.ump_active = 'Y')";
        $wheres[] = '(ump.ump_deleted_on IS NULL)';
        $wheres[] = "(ss.ss_active = 'Y')";
        $wheres[] = '(ss.ss_deleted_on IS NULL)';
        $data = self::loadData($wheres);

        return $data[0];
    }

    /**
     * function to get all available fields
     *
     * @param int $ssId To Store the user data.
     *
     * @return array
     */
    public static function loadAllUserMappingDataForSystem($ssId): array
    {
        $result = [];
        $wheres = [];
        $wheres[] = '(ss_id <> ' . $ssId . ')';
        $wheres[] = "(ss_active = 'Y')";
        $wheres[] = '(ss_deleted_on IS NULL)';
        $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        $query = 'SELECT  ss_id, ss_logo, ss_relation, ss_system
					FROM system_setting ' . $strWhere;
        $query .= ' GROUP BY ss_id, ss_logo, ss_relation, ss_system';
        $query .= ' ORDER BY ss_system, ss_relation';
        $sqlResult = DB::select($query);
        if (empty($sqlResult) === false) {
            $result = DataParser::arrayObjectToArray($sqlResult, [
                'ss_id',
                'ss_logo',
                'ss_relation',
                'ss_system',
            ]);
        }

        return $result;
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
        $wheres[] = '(ump.ump_id = ' . $referenceValue . ')';
        $data = self::loadData($wheres);

        return $data[0];
    }

    public static function loadData(array $wheres = []): array
    {
        $strWhere = '';
        if (empty($wheres) === false) {
            $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        }
        $query = 'SELECT  ump.ump_id, ump.ump_ss_id, ump.ump_us_id, ump.ump_default, ump.ump_active,
                    ump.ump_level_id,ss.ss_relation, ss.ss_system , ss.ss_name_space,
					ss.ss_decimal_number, ss.ss_decimal_separator,ss.ss_thousand_separator,ss.ss_logo,ss.ss_id,
					sty.sty_name as ump_sty_name
					FROM user_mapping as ump
					INNER JOIN system_setting as ss ON ump.ump_ss_id = ss.ss_id
					INNER JOIN system_type as sty on sty.sty_id = ump.ump_level_id' . $strWhere;
        $sqlResults = DB::select($query);

        return DataParser::arrayObjectToArray($sqlResults);
    }
}
