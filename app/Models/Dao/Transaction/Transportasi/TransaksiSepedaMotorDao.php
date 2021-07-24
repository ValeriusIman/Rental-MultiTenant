<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Models\Dao\Transaction\Transportasi;

use App\Frame\Mvc\AbstractBaseDao;
use App\Frame\Formatter\DataParser;
use Illuminate\Support\Facades\DB;

/**
 * Class to handle data access object for table transaksi_sepeda_motor.
 *
 * @package    app
 * @subpackage Models\Dao\Transaction\Transportasi
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiSepedaMotorDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'tsm_id',
        'tsm_as_id',
        'tsm_tr_id',
        'tsm_harga',
        'tsm_denda',
    ];

    /**
     * Base dao constructor for transaksi_sepeda_motor.
     *
     */
    public function __construct()
    {
        parent::__construct('transaksi_sepeda_motor', 'tsm', self::$Fields);
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
        $wheres[] = '(tsm.tsm_id = ' . $referenceValue . ')';
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
    public static function getByTransaksiId($referenceValue): array
    {
        $wheres = [];
        $wheres[] = '(tsm.tsm_tr_id = ' . $referenceValue . ')';
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
        $wheres[] = '(tsm.tsm_id = ' . $referenceValue . ')';
        $wheres[] = '(tsm.tsm_ss_id = ' . $ssId . ')';
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
        $query = 'SELECT tsm.tsm_id, tsm.tsm_as_id, tsm.tsm_tr_id, tsm.tsm_harga, tsm.tsm_denda, tr.tr_number as tsm_tr_number,
                        tr.tr_eta_date, tr.tr_eta_time, tr.tr_ata_date, tr.tr_ata_time, tr.tr_finish_on, tr.tr_name_customer,
                        srv.srv_code as tr_srv_code, tr.tr_srv_id, sty.sty_name as tr_sty_jaminan, sp.sp_variant as tsm_sp_variant,
                        sp.sp_harga as tsm_sp_harga, sp.sp_warna_id, sty1.sty_name as tsm_warna, tr.tr_total, tr.tr_bayar
                        FROM transaksi_sepeda_motor as tsm
                        INNER JOIN transaksi as tr on tr.tr_id = tsm.tsm_tr_id
                        INNER JOIN service as srv on srv.srv_id = tr.tr_srv_id
                        INNER JOIN system_setting as ss on tr.tr_ss_id = ss.ss_id
                        INNER JOIN system_type as sty on sty.sty_id = tr.tr_jaminan_id
                        LEFT JOIN sepeda_motor as sp on sp.sp_as_id = tsm.tsm_as_id
                        LEFT JOIN system_type as sty1 on sty1.sty_id = sp.sp_warna_id' . $strWhere;
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
