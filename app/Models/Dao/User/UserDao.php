<?php

namespace App\Models\Dao\User;

use App\Frame\Formatter\DataParser;
use App\Frame\Mvc\AbstractBaseDao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function count;

class UserDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'us_id',
        'us_name',
        'us_username',
        'us_system',
        'us_active',
    ];

    /**
     * Base dao constructor for users.
     */
    public function __construct()
    {
        parent::__construct('users', 'us', self::$Fields);
    }

    /**
     * Function to get the user by email.
     *
     * @param string $id To set the username of the user.
     *
     * @return array
     */
    public static function getById($id): array
    {
        $result = [];
        $wheres = [];
        $wheres[] = "(us_id = '" . $id . "')";
        $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        $query = 'SELECT us_id, us_name, us_username, us_active, us_system
					FROM users ' . $strWhere;
        $data = DB::select($query);
        if (count($data) === 1) {
            $result = DataParser::objectToArray($data[0], [
                'us_id',
                'us_name',
                'us_username',
                'us_active',
                'us_system',
            ]);
        }

        return $result;
    }

    /**
     * Function to get all the data for the login information.
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function getLoginData($username, $password): array
    {
        $result = [];
        $wheres = [];
        $wheres[] = "(us.us_username = '" . $username . "')";
        $wheres[] = "(us.us_active = 'Y')";
        $wheres[] = '(us.us_deleted_on IS NULL)';
        $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        $query = 'SELECT us.us_id, us.us_name, us_username, us.us_password, us.us_system, us.us_active
                    FROM users as us ' . $strWhere;
        $query .= ' GROUP BY us.us_id, us_username, us.us_password, us.us_system, us.us_active';
        $sqlResult = DB::select($query);
        if (count($sqlResult) === 1) {
            $arrData = DataParser::objectToArray($sqlResult[0]);
            if (Hash::check($password, $arrData['us_password']) === true) {
                $result = [
                    'us_id' => $arrData['us_id'],
                    'us_name' => $arrData['us_name'],
                    'us_username' => $arrData['us_username'],
                    'us_password' => $arrData['us_password'],
                    'us_system' => $arrData['us_system'],
                    'us_active' => $arrData['us_active'],
                ];
            }
        }
        return $result;
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
        $wheres[] = '(us.us_id = ' . $referenceValue . ')';
        $data = self::loadData($wheres);

        return $data[0];
    }

    /**
     * Function to get all record.
     *
     * @param array $wheres To store the list condition query.
     * @return array
     */
    public static function loadData(array $wheres = []): array
    {
        $strWhere = '';
        if (empty($wheres) === false) {
            $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        }
        $query = 'SELECT us.us_id, us.us_name, us.us_username, us.us_system, us.us_active,us.us_password
                    FROM users as us' . $strWhere;
        $result = DB::select($query);

        return DataParser::arrayObjectToArray($result);

    }

    /**
     * Function to get all record.
     *
     *
     * @return array
     */
    public static function loadSelectData(): array
    {
        $wheres[] = "(us_active = 'Y')";
        $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        if (empty($wheres) === false) {
            $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        }
        $query = 'SELECT us_id, us_name, us_username, us_system, us_active
                    FROM users' . $strWhere;
        $result = DB::select($query);

        return DataParser::arrayObjectToArray($result, self::$Fields);

    }


}
