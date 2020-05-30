<?php namespace App\Controllers;

class College extends BaseController {
	public $db = "";

	public function __construct() {
		$this->db = \Config\Database::connect();
	}

	public function getcollegesList() {
		$sql = "select * from tb_colleges";
		$query = $this->db->query($sql);
		$res = array();
		//查大学列表
		foreach ($query->getResultArray() as $row) {

			$tmp = array();
			$tmp["id"] = $row["college_id"];
			$tmp["name"] = $row["college_name"];
			$tmp["logo"] = $row["college_logo"];

			//查当个大学的标签
			$getTagsSql = "SELECT tagname FROM tb_colleges_tag  WHERE college_id = ? ";
			$getTagsQuery = $this->db->query($getTagsSql, [$row["collegesid"]]);

			$tags = array();
			foreach ($getTagsQuery->getResultArray() as $row) {
				$tags[] = $row['tagname'];
			}

			$tmp["tags"] = $tags;

			$res[] = $tmp;
		}

		echo json_encode($res, true);
	}

	public function getcollegesData() {
		$arrayName = array('college_name' => "清华大学", "college_addr" => "beijing");
		echo json_encode($arrayName, true);
	}

	public function getcollegesDetail($college_id) {

		$sql = "SELECT * FROM tb_colleges  WHERE college_id = ? ";

		$query = $this->db->query($sql, [$college_id]);

		$res = array();

		foreach ($query->getResult() as $row) {

			$res["data"] = $row;

		}

		$sql = "SELECT tagname FROM tb_colleges_tag  WHERE college_id = ? ";
		$query = $this->db->query($sql, [$college_id]);

		$tags = array();
		foreach ($query->getResultArray() as $row) {
			$tags[] = $row['tagname'];

		}

		$res["tags"] = $tags;

		echo json_encode($res, true);

	}

	public function test() {

		$query = $this->db->query('SELECT * FROM test');

		foreach ($query->getResult() as $row) {
			echo json_encode($row, true);

		}
	}

}
