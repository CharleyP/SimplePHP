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
		print_r($request->param());
		exit;
		// $query = new Query();
		// $data = $query->table("user")->select();
		// print_r($data);
	}
	public function test(){
		$view = new View();
		$query = new Query();
		$sql = $query->table("p101")->select("UID,EID,PHONE");
		$list = "1234";
		$view->assign("sql",$sql);
		$view->assign("list",$list);
		$view->fetch();
	}
	public function insert(){
		// $data = [
		// 	['id'=>1,'name'=>'jack1','age'=>21],
		// 	['id'=>2,'name'=>'jack2','age'=>22],
		// 	['id'=>3,'name'=>'jack3','age'=>23],
		// ];
		$data = ['id'=>1,'name'=>'jack1','age'=>21,'scholl'=>null];
		$query = new Query();
		$sql = $query->table("p101")->insert($data);
		echo $sql;
	}
	public function update(){
		$query = new Query();
		$data = array(
			'name'	=>	'jack',
			'age'	=>	20,
		);
		$where['id'] = 1;
		$where['name'] = 1;
		//$where = "id=1 or (id=2 and age>20)";
		//$sql = "update user set name='jack',age=20 where id=1 and name=1";
		$sql = $query->table("user")->where($where)->update($data);
	}
	public function delete(){
		//$sql="delete from table where ...";
		$query = new Query();
		//$where['id'] = ['in',[1,2,3]];
		$where = "id in (1,2,3)";
		$sql = $query->table("user")->where($where)->delete();
	}
}

 ?>