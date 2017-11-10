<?php 
namespace lib\db;

use lib\App;

class PDOConn implements Mysql
{
	public $conn = null;

	public function __construct()
	{
		if($this->conn == null){
			$this->getDatabaseInfo();
			$this->connect();
		}
	}
	public function getDatabaseInfo(){
		$this->host = APP::$config['hostname'];
		$this->db = APP::$config['database'];
		$this->username = APP::$config['username'];
		$this->password = APP::$config['password'];
	}
	public function connect(){
		// $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->username, $this->password);//这个不是长连接
		$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->username, $this->password,array(PDO::ATTR_PERSISTENT => true));//长连接
	}
	public function insert($query){

	}
	public function update($query){

	}
	public function select($query){
		//第一种方法
		// $data = $this->conn->prepare($query);
		// $data->execute();
		// return $data->fetchAll();
		//第二种方法
		$data = array();
	    foreach ($this->conn->query($query) as $row) {
	    	$data[] = $row;
	    }
	    return $data;
	}
	public function delete($query){

	}
}



 ?>