<?php namespace App\Controllers;

class majors extends BaseController {
	public $db = "";

	public function __construct() {
		$this->db = \Config\Database::connect();
	}


	public function getmajorsList() {
		$sql = "select * from majors_list";
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