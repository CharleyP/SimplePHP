<?php
namespace lib\db;
/**
* 
*/
//$conn = new Connection();
class Connection
{
	protected $host = "localhost";
	protected $db = "pes";
	protected $username = "root";
	protected $password = "gaosubo3000";
	protected $conn = null;
	function __construct()
	{
		if($this->conn == null){
			$this->connect();
		}
	}
	public function connect(){
		try {
		    $conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->username, $this->password);
		    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $this->conn = $conn;
		    return $this->conn;
		}
		catch(PDOException $e)
		{
		    //echo $e->getMessage();
		}
	}
}



 ?>