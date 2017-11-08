<?php
namespace lib\db;

use lib\db\Mysqli;
use lib\db\PDO;
use lib\Exception;
/**
* 
*/
//$conn = new Connection();
class Connection
{
	protected $host = "localhost";
	protected $db = "test";
	protected $username = "root";
	protected $password = "root";
	protected $conn = null;
	protected $type = "mysqli";
	function __construct()
	{
		if($this->conn == null){
			$this->connect();
		}
	}
	public function connect(){
		try {
			if(empty($type)){
				throw new Exception("请选择MySQL连接方式");
			}
			if($this->type == "mysqli"){
				$conn = new Mysqli($this->host, $this->username, $this->password, $this->db);
			}else if($this->type == "pdo"){
				$conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->username, $this->password);
			}else{
				throw new Exception("请选择MySQL连接方式");
			}
		    $this->conn = $conn;
		    return $this->conn;
		}
		catch(Exception $e)
		{
		    echo $e->getMessage();
		    exit();
		}
	}
	public function query($query){
		$result = $this->conn->query($query);
		$data=array();
		while ($tmp=mysqli_fetch_assoc($result)) {
		    $data[]=$tmp;
		}
		return $data;
	}
	public function queryMysqli($query){
		$result = $this->conn->query($query);
		$data=array();
		while ($tmp=mysqli_fetch_assoc($result)) {
		    $data[]=$tmp;
		}
		return $data;
	}
	public function queryPDO(){

	}
}



 ?>