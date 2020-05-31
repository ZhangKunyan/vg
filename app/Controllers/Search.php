<?php namespace App\Controllers;

class Search extends BaseController
{
    public $db = "";

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function like($type)
    {
        $request = $this->request;

        $text = $request->getVar("text");
        $sql  = " ";

        if ($type == "college") {
            $sql = "SELECT c.college_id as id,c.college_name as name from tb_colleges c where c.college_name like ?";
        }

        $query = $this->db->query($sql, ["%" . $text . "%"]);

        $res['pretext'] = $query->getResultArray();
        echo json_encode($res, true);
    }

}
