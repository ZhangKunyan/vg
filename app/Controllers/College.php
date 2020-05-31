<?php namespace App\Controllers;

class College extends BaseController
{
    public $db = "";

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getcollegesList()
    {
        $sql   = "select * from tb_colleges";
        $query = $this->db->query($sql);
        $res   = array();
        //查大学列表
        foreach ($query->getResultArray() as $row) {

            $tmp         = array();
            $tmp["id"]   = $row["college_id"];
            $tmp["name"] = $row["college_name"];
            $tmp["logo"] = $row["college_logo"];

            //查当个大学的标签
            $getTagsSql   = "SELECT tagname FROM tb_colleges_tag  WHERE college_id = ? ";
            $getTagsQuery = $this->db->query($getTagsSql, [$row["college_id"]]);

            $tags = array();
            foreach ($getTagsQuery->getResultArray() as $row) {
                $tags[] = $row['tagname'];
            }

            $tmp["tags"] = $tags;

            $res[] = $tmp;
        }

        echo json_encode($res, true);
    }

    public function getcollegesData()
    {
        $arrayName = array('college_name' => "清华大学", "college_addr" => "beijing");
        echo json_encode($arrayName, true);
    }

    public function getcollegesDetail($college_id)
    {

        $res = array();

        //基本信息
        $sql = "SELECT * FROM tb_colleges  WHERE college_id = ? ";

        $query = $this->db->query($sql, [$college_id]);

        foreach ($query->getResultArray() as $row) {

            $res["id"]         = $row['college_id'];
            $res["name"]       = $row['college_name'];
            $res["location"]   = $row['college_addr'];
            $res["logo"]       = $row['college_logo'];
            $res["intro"]      = $row['college_intro'];
            $res["enroll_net"] = $row['enroll_net'];
            $res["enroll_tel"] = $row['enroll_tel'];
            $res["enroll_id"]  = $row['enroll_id'];

        }

        //查询标签
        $sql   = "SELECT tagname FROM tb_colleges_tag  WHERE college_id = ? ";
        $query = $this->db->query($sql, [$college_id]);

        $tags = array();
        foreach ($query->getResultArray() as $row) {
            $tags[] = $row['tagname'];

        }

        $res["tags"] = $tags;

        //分数线信息

        $sql         = "SELECT batch,max(c.grade_max) as max, min(c.grade_min) as min FROM tb_colline c where  c.college = ? and c.year = 2020 and c.type= 0 and c.province = '北京' group by batch; ";
        $query       = $this->db->query($sql, [$college_id]);
        $res['line'] = $query->getResultArray();

        echo json_encode($res, true);

    }

    public function getcollegesLine($college, $year)
    {

        $request = $this->request;

        $res      = array();
        $province = $request->getVar("province");
        $type     = $request->getVar("type");

        if ($type == "理科") {
            $type = 0;
        } else {
            $type = 1;
        }

        $sql   = "SELECT batch,max(c.grade_max) as max, min(c.grade_min) as min FROM tb_colline c where  c.college = ? and c.year = ? and c.type= ? and c.province= ?  group by batch;";
        $query = $this->db->query($sql, [$college, $year, $type, $province]);

        $res['line'] = $query->getResultArray();

        echo json_encode($res, true);
    }

    public function test()
    {

        $query = $this->db->query('SELECT * FROM test');

        foreach ($query->getResult() as $row) {
            echo json_encode($row, true);

        }
    }

}
