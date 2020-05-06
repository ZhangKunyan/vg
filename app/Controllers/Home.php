<?php namespace App\Controllers;

class Home extends BaseController {
	public function index() {
		//return view('welcome_message');
		$res = array('desc' => "高考志愿 API接口服务");
		echo json_encode($res, true);
	}

	//--------------------------------------------------------------------

}
