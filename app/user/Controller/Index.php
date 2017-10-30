<?php 
namespace app\user\Controller;

use lib\db\Query;

class Index
{
	public function index()
	{
		$query = new Query();
		$sql = $query->table("p101")->select("UID,EID,PHONE");
		return $sql;
	}
}

 ?>