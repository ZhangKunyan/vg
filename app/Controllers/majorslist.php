<?php namespace App\Controllers;

class majorslist extends BaseController {
	public $db = "";

	public function __construct() {
		$this->db = \Config\Database::connect();
	}

//获取大类小类
	public function getmajorsList() {
		// $sql = "select * from tb_majors";
		// $query = $this->db->query($sql);
		// $res = array();
		// //查大学列表
		// foreach ($query->getResultArray() as $row) {

		// 	$tmp = array();
		// 	$tmp["items.id"] = $row["majorid"];
		// 	$tmp["items.name"] = $row["name"];
		// 	$tmp["nameclass"] = $row["kind"];

		// 	$res[] = $tmp;
		// }

		// echo json_encode($res, true);

		$majorslist = array();

		$sql1 = "SELECT DISTINCT class FROM `tb_majors` WHERE 1";
		$query1 = $this->db->query($sql1);

		foreach ($query1->getResultArray() as $row) {
			$name1 = $row["class"];
			$item1 = array(
				"name" => $name1,
				"level" => 0,
				"items" => array(),
			);

			$sql2 = "SELECT DISTINCT  classkid FROM `tb_majors` WHERE class = ? ";

			$query2 = $this->db->query($sql2, $name1);

			foreach ($query2->getResultArray() as $row) {
				$name2 = $row["classkid"];
				$item2 = array(
					"name" => $name2,
					"level" => 1,
				);

				$item1["items"][] = $item2;

			}

			$majorslist[] = $item1;
		}
		echo json_encode($majorslist, true);
	}

}