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
		$this->host = APP::$config['hostname'];
		$this->db = APP::$config['database'];
		$this->username = APP::$config['username'];
		$this->password = APP::$config['password'];
	}
	public function connect(){
		$this->conn = new \Mysqli($this->host, $this->username, $this->password, $this->db);
	}
	public function insert($query){
		if ($this->conn->query($query) === TRUE) {
			$affected_rows = $this->conn->affected_rows;
			$last_insert_id = $this->conn->insert_id;
			if($affected_rows > 1){
				$last_insert_ids = "";
				for ($i=$last_insert_id; $i < $last_insert_id+$affected_rows; $i++) { 
					$last_insert_ids .= $i.",";
				}
				return trim($last_insert_ids,",");
			}else{
				return $last_insert_id;
			} 
		}else{
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}
	public function update($query){
		if ($this->conn->query($query) === TRUE) {
			return $this->conn->affected_rows;
		}else{
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}
	public function select($query){
		
		$result = $this->conn->query($query);
		$data=array();
		if ($result->num_rows > 0) {//先判断获取行数
			while ($tmp=$result->fetch_assoc()) {
			    $data[]=$tmp;
			}
		}
		return $data;
	}
	public function delete($query){

	}
}

 ?>