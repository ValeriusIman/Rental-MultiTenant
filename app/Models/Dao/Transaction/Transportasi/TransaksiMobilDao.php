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
 * Class to handle data access object for table transaksi_mobil.
 *
 * @package    app
 * @subpackage Models\Dao\TransactionMobil
 * @author     Valerius Iman
 * @copyright  2021 Multi Mutiara Rental.
 */
class TransaksiMobilDao extends AbstractBaseDao
{
    /**
     * The field for the table.
     *
     * @var array
     */
    private static $Fields = [
        'trm_id',
        'trm_as_id',
        'trm_tr_id',
        'trm_dr_id',
        'trm_price',
    ];

    /**
     * Base dao constructor for transaksi_mobil.
     *
     */
    public function __construct()
    {
        parent::__construct('transaksi_mobil', 'trm', self::$Fields);
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
        $wheres[] = '(trm.trm_id = ' . $referenceValue . ')';
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
        $wheres[] = '(trm.trm_tr_id = ' . $referenceValue . ')';
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
        $wheres[] = '(trm.trm_id = ' . $referenceValue . ')';
        $wheres[] = '(trm.trm_ss_id = ' . $ssId . ')';
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
        $query = 'SELECT trm.trm_id, trm.trm_as_id, trm.trm_dr_id, trm.trm_price, trm.trm_driver_fee,
                        trm.trm_tr_id, tr.tr_id, tr.tr_number, tr.tr_ss_id, tr.tr_eta_date, tr.tr_eta_time,
                        tr.tr_ata_time, tr.tr_ata_date, tr.tr_name_customer, tr.tr_jaminan_id, tr.tr_finish_on,
                        tr.tr_srv_id, srv.srv_code as tr_srv_code, sty.sty_name, dr.dr_name, mb.mb_variant, trm.trm_denda,
                        tr.tr_total, trm.trm_driver_fee, trm.trm_price
                    FROM transaksi_mobil as trm
                    INNER JOIN transaksi as tr on tr.tr_id = trm.trm_tr_id
                    INNER JOIN service as srv on srv.srv_id = tr.tr_srv_id
                    INNER JOIN system_setting as ss on tr.tr_ss_id = ss.ss_id
                    INNER JOIN system_type as sty on sty.sty_id = tr.tr_jaminan_id
                    INNER JOIN mobil as mb on mb.mb_as_id = trm.trm_as_id
                    LEFT JOIN driver as dr on dr.dr_id = trm.trm_dr_id' . $strWhere;
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
