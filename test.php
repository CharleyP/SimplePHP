<?php
require 'index.php';
use lib\db\Query;

$query = new Query();



$sql = $query->table("p101")->select("UID,EID,PHONE");
echo $sql;
// include_once "Query.class.php";
// include_once "Connection.class.php";
// $query = new Query();
// $connection = new Connection();
// $conn = $connection->connect();
// $sql = $query->table("p101")->select("UID,EID,PHONE");
// $data = $conn->prepare($sql); 
// $data->execute();
// print_r($data->fetchAll());
// exit;

// include_once "Query.class.php";
// include_once "Connection.class.php";

// $query = new Query();
// $connection = new Connection();
// $conn = $connection->connect();
// $sql = $query->table("p101")->select("UID,EID,PHONE");
// $data = $conn->prepare($sql); 
// $data->execute();
// print_r($data->fetchAll());
// exit;


/*$query = new Query();
$where_arr['UID'] = 1;
$where_arr['AGE'] = [">",20];
$where_arr['NAME'] = "jack";
$whereOr['UID'] = 2;
$whereOr['AGE'] = ["<",20];
$order["UID"] = "desc";
$order["NAME"] = "asc";


$join = [
    ['dept b','b.did=a.did'],
    ['priv c','c.priv_id=a.pid','left'],
];
$sql = $query->table("user")->where("UID=1 and AGE>20")->where("UID=2","OR")->select();*/
//$sql = $query->table("user")->where($where_arr,'and')->where($whereOr,"or")->group("id,name")->order("UID")->limit(10, 20)->select();
// $sql = "select * from user left join dept on user.uid = dept.uid";
// $sql = $query->table("user")->alias("a")->join($join)->count();
// $sql = $query->table("user")->alias("a")->join("dept b","a.did=b.did")->select();
//$sql = $query->table("user")->join("dept","dept.did=user.did")->join("priv","priv.pid=user.pid","left")->select();

 ?>