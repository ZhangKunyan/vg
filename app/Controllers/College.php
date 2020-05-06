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
			$tmp["id"] = $row["collegesid"];
			$tmp["name"] = $row["name"];
			$tmp["logo"] = $row["logo"];

			//查当个大学的标签
			$getTagsSql = "SELECT tagname FROM tb_colleges_tag  WHERE collegesid = ? ";
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
		$arrayName = array('name' => "清华大学", "address" => "beijing");
		echo json_encode($arrayName, true);
	}

	public function getcollegesDetail($collegeid) {

		$sql = "SELECT * FROM tb_colleges  WHERE collegesid = ? ";

		$query = $this->db->query($sql, [$collegeid]);

		$res = array();

		foreach ($query->getResult() as $row) {

			$res["data"] = $row;

		}

		$sql = "SELECT tagname FROM tb_colleges_tag  WHERE collegesid = ? ";
		$query = $this->db->query($sql, [$collegeid]);

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
