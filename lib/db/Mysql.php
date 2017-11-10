<?php 
namespace lib\db;

interface Mysql{
	public function connect();
	public function insert($query);
	public function update($query);
	public function select($query);
	public function delete($query);
}



 ?>