<?php

namespace App\Models\Dao\System;

use App\Frame\Formatter\DataParser;
use App\Frame\Mvc\AbstractBaseDao;
use Illuminate\Support\Facades\DB;

class SystemSettingDao extends AbstractBaseDao
{

    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'ss_id',
        'ss_relation',
        'ss_decimal_number',
        'ss_decimal_separator',
        'ss_thousand_separator',
        'ss_logo',
        'ss_name_space',
        'ss_system',
        'ss_active',
    ];

    /**
     * Base dao constructor for users.
     */
    public function __construct()
    {
        parent::__construct('system_setting', 'ss', self::$Fields);
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
        $wheres[] = '(ss.ss_id = ' . $referenceValue . ')';
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
     * @return array
     */
    public static function loadData(array $wheres = [],array $orders = []): array
    {
        $strWhere = '';
        if (empty($wheres) === false) {
            $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        }
        $query = 'SELECT ss.ss_id, ss.ss_relation, ss.ss_decimal_number, ss.ss_decimal_separator, ss.ss_system,
                    ss.ss_active, ss.ss_name_space, ss.ss_logo,ss_thousand_separator
                    FROM system_setting as ss ' . $strWhere;
        if (empty($orders) === false) {
            $query .= ' ORDER BY ' . implode(', ', $orders);
        }
        $result = DB::select($query);

        return DataParser::arrayObjectToArray($result, self::$Fields);

    }

    public static function loadMenu():array {

        $query = 'SELECT ss.ss_id,ss.ss_relation,ssr.ssr_srv_id,srv.srv_code, srv.srv_name,
                            mn.mn_name, mn.mn_route, mn.mn_icon, mn.mn_active, mn.mn_sub_menu
                    FROM menu as mn
                    LEFT OUTER JOIN service as srv on mn.mn_srv_id = srv.srv_id
                    LEFT OUTER JOIN system_service as ssr on srv.srv_id = ssr.ssr_srv_id
                    LEFT OUTER JOIN system_setting as ss on ssr.ssr_ss_id = ss.ss_id';
        $result = DB::select($query);

        return DataParser::arrayObjectToArray($result);
    }

}
