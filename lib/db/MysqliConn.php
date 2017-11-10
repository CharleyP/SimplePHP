<?php 
namespace lib\db;

use lib\App;


class MysqliConn implements Mysql
{
	public $conn = null;
	public $host = "localhost";
	public $db = "test";
	public $username = "root";
	public $password = "";

	public function __construct()
	{
		if($this->conn == null){
			$this->getDatabaseInfo();
			$this->connect();
		}
	}
	public function getDatabaseInfo(){
		$dataBaseInfo = APP::getConfig();
		$this->host = $dataBaseInfo['hostname'];
		$this->db = $dataBaseInfo['database'];
		$this->username = $dataBaseInfo['username'];
		$this->password = $dataBaseInfo['password'];
	}
	public function connect(){
		$this->conn = new \Mysqli($this->host, $this->username, $this->password, $this->db);
	}
	public function insert($query){

	}
	public function update($query){

	}
	public function select($query){
		
		$result = $this->conn->query($query);
		$data=array();
		while ($tmp=mysqli_fetch_assoc($result)) {
		    $data[]=$tmp;
		}
		return $data;
		// print_r($data);
		// exit;
	}
	public function delete($query){

	}
}

 ?>