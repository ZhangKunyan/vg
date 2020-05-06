<?php namespace App\Controllers;

class majorslist extends BaseController {
	public $db = "";

	public function __construct() {
		$this->db = \Config\Database::connect();
	}

	public function getmajorsList() {
		$sql = "select * from tb_majors";
		$query = $this->db->query($sql);
		$res = array();
		//查大学列表
		foreach ($query->getResultArray() as $row) {

			$tmp = array();
			$tmp["items.id"] = $row["majorid"];
			$tmp["items.name"] = $row["name"];
			$tmp["nameclass"] = $row["kind"];

			$res[] = $tmp;
		}

		echo json_encode($res, true);
	}
}