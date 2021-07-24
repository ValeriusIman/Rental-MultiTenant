<?php

namespace App\Http\Controllers;

use App\Frame\Formatter\DataParser;
use App\Frame\Formatter\SqlHelper;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{

    private $Id;
    private $Value;

    public function __construct($id,$value)
    {
        $this->Id = $id;
        $this->Value = $value;
    }

    function ifNull($data, $return): int
    {
        if ($data === NULL) {
            $data = $return;
        }
        return $data;
    }

    public function cekUnique(): void
    {
//        $id = $this->ifNull($this->Id, 0);
//        $nip = $this->Value;
//        $query = "select id "
//            . "from staff_pendidik "
//            . "where nip='$nip'";
        $wheres[] = SqlHelper::generateLikeCondition('sty_group', 'modultransportasi');
        $wheres[] = SqlHelper::generateLikeCondition('sty_name', 'Darata');
        $strWhere = ' WHERE ' . implode(' AND ', $wheres);
        $query = "SELECT sty_id FROM system_type " . $strWhere;
        $result = DB::select($query);
        if ($result !== []) {
            $cek = DataParser::objectToArray($result[0]);
            $tes = $cek['sty_id'];
        } else {
            $tes = NULL;
        }
        if ($tes !== NULL) {
            if ("" . $tes === 0) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "true";
        }
    }
}
