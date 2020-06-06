<?php namespace App\Controllers;

class Line extends BaseController
{
    public $db = "";

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getprovinceline()
    {
        $request = $this->request;

        $province = $request->getVar("province");
        $year     = $request->getVar("year");
        $sql      = " ";

        $sql = "SELECT * from tb_provinceline c where c.province = ? and c.pro_year = ?";

        $query = $this->db->query($sql, [$province, $year]);

        $res['data'] = $query->getResultArray();
        echo json_encode($res, true);
    }

}
