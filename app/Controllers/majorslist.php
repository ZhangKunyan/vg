<?php namespace App\Controllers;

class majorslist extends BaseController {
	public $db = "";

	public function __construct() {
		$this->db = \Config\Database::connect();
	}

//获取大类小类
	public function getmajorsClassList($type = 0) {

		$majorBatch = 'Undergraduate';

		if ($type == 'Specialty') {
			$majorBatch = $type;
		}

		$majorslist = array();

		$sql1 = "SELECT DISTINCT  major_class FROM `tb_majorclass` WHERE major_batch = ?";
		$query1 = $this->db->query($sql1, [$majorBatch]);

		foreach ($query1->getResultArray() as $row) {

			$name1 = $row["major_class"];
			$item1 = array(
				"name" => $name1,
				"level" => 0,
				"items" => array(),
			);

			$sql2 = "SELECT DISTINCT class_id,  major_classkid FROM `tb_majorclass` WHERE major_class = ? and  major_batch = ?";

			$query2 = $this->db->query($sql2, [$name1, $majorBatch]);

			foreach ($query2->getResultArray() as $row) {
				$name2 = $row["major_classkid"];
				$class_id = $row["class_id"];
				$item2 = array(
					"name" => $name2,
					"level" => 1,
					"id" => $class_id,
				);

				$item1["items"][] = $item2;

			}

			$majorslist[] = $item1;
		}
		echo json_encode($majorslist, true);
	}

	public function getmajorsList($classid) {

		// [{
		//   nameclass:"基本专业",
		//   items: [{
		//     id:100,
		//     name: "智能电网信息工程"
		//   }, {
		//     id: 101,
		//     name: "光源与照明"
		//   }, {
		//       id: 103,
		//     name: "电气工程与智能控制"
		//   }]
		// },]
		$majorslist = array();
		$sql = "SELECT DISTINCT type FROM `tb_major` where  classid =  ?";
		$query = $this->db->query($sql, [$classid]);
		$res = [];
		foreach ($query->getResultArray() as $row) {
			$items = array();
			$items['nameclass'] = $row['type'];
			$majors = array();
			$sql = "SELECT * FROM`tb_major`where classid =  ?  and type =  ? ";
			$query = $this->db->query($sql, [$classid, $row['type']]);
			foreach ($query->getResultArray() as $major) {
				$tmp = array();
				$tmp["id"] = $major["id"];
				$tmp["name"] = $major["name"];
				$majors[] = $tmp;
			}
			$items["items"] = $majors;
			$res[] = $items;
		}
		echo json_encode($res, true);
	}

	public function getmajorDetail($majorid) {

		$sql = "select * from tb_major t, tb_majorclass c where t.classid = c.class_id and t.id =  ?";
		$query = $this->db->query($sql, [$majorid]);
		$res = $query->getResultArray();
		echo json_encode($res, true);
	}

}
