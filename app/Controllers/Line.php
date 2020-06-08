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

    public function pushbygrade()
    {
        $request = $this->request;

        $region = $request->getVar("region");
        $grade1 = $request->getVar("grade1");
        $grade2 = $request->getVar("grade2");
        $grade3 = $request->getVar("grade3");
        $grade4 = $request->getVar("grade4");
        $type   = $request->getVar("type");

        if ($type == "理科") {
            $type = 0;
        } else {
            $type = 1;
        }

        $sum = $grade1 + $grade2 + $grade3 + $grade4;

        $sql = "select DISTINCT (SELECT college.college_name from tb_colleges college where  college.college_id = c.college) as name ,c.major from tb_colline c where c.year =?  and type =? and c.grade_min <? order by c.college  limit 10 ";

        $query = $this->db->query($sql, [date("Y", strtotime("-1 year")), $type, $sum]);

        $res['data'] = $query->getResultArray();
        echo json_encode($res, true);
    }

}
