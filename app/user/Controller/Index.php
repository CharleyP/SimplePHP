<?php 
namespace app\user\Controller;

use lib\db\Query;
use lib\Request;
use lib\Controller;
use lib\View;


class Index extends Controller
{
	public function index(Request $request)
	{
		//print_r($request->param('qe'));
		//$request = Request::instance();
		//echo $request->param();
		//exit;

		$query = new Query();
		$data = $query->table("user")->select();
		print_r($data);
	}
	public function test(){
		$view = new View();
		$query = new Query();
		$sql = $query->table("p101")->select("UID,EID,PHONE");
		$list = "1234";
		$view->assign("sql",$sql);
		$view->assign("list1",$list);
		$view->fetch();
	}
}

 ?>