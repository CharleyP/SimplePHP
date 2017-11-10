<?php 
namespace lib\db;

class MysqliConn implements Mysql
{
	public $conn = null;
	public $host = "localhost";
	public $db = "test";
	public $username = "root";
	public $password = "root";

	public function __construct()
	{
		if($this->conn == null){
			$this->connect();
		}
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
	}
	public function delete($query){

	}
}

 ?>