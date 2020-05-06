<?php namespace App\Controllers;

class User extends BaseController
{
	public function index()
	{
		$arrayName = array('username' => "zky","age"=>12 );
		echo json_encode($arrayName,true);
	}


	public function aa()
	{
		$arrayName = array('username' => "hcy","age"=>88 );
		echo json_encode($arrayName,true);
	}


	public function bb()
	{
		$arrayName = array('username' => "1111hcy","age"=>88 );
		echo json_encode($arrayName,true);
	}

	//--------------------------------------------------------------------

}
