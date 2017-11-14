<?php
namespace lib\db;
use lib\db\MysqliConn;
use lib\App;
/**
* 
*/
class Query
{
	protected $query;
	protected $table;
	protected $where;
	protected $limit;
	protected $order;
	protected $group;
	protected $join;
	
	public function __construct(){

	}
	public function getMySQLType(){
		
	}
	public function table($table){
		$this->table = $table;
		return $this;
	}
	public function alias($value = ""){
		if(!empty($value)){
			$this->table .= " AS ".$value;
		}
		return $this;
	}
	public function select($columns = "*"){
		$columns = trim($columns,",");
		if(!empty($this->where)){
			$this->where = " WHERE ".$this->where;	
		}
		$this->query = "SELECT ".$columns." FROM ".$this->table.$this->join.$this->where.$this->group.$this->order.$this->limit;
		//return $this->query;
		return $this->conn(__FUNCTION__);
	}
	public function limit($start = "" ,$end = ""){
		if(!empty($end) && !empty($start)){
			$this->limit .= " LIMIT ".$start.",".$end;
		}else if(!empty($start)){
			$this->limit .= " LIMIT ".$start;
		}else{

		}
		return $this;
	}
	public function group($columns = ""){
		$columns = trim($columns,",");
		if(!empty($columns)){
			$this->group = " GROUP BY ".$columns." ";
		}
		return $this;
	}
	/**
	 *支持order("uid,uname","desc/asc")//可单字段可多字段
	 *order(["uid"=>"desc","uname"=>"asc"])//支持传入数组
	*/
	public function order($columns = "" ,$type = "DESC"){
		$this->order = " ORDER BY ";
		if(is_array($columns)){//如果传入的是数组形式的
			foreach ($columns as $key => $value) {
				$this->order .= $key." ".strtoupper($value).",";
			}
		}else if(!empty($columns) && is_string($columns)){//如果传入的是字符串形式的
			$columns_arr = explode(",",trim($columns,","));
			foreach ($columns_arr as $value) {
				$this->order .= $value." ".strtoupper($type).",";
			}
		}else{
			$this->order = "";
		}
		$this->order = trim($this->order,",");
		return $this;
	}
	/*支持传入
	$insert = array(
		'id'	=>	1,
		'name'	=>	'jack',
		'age'	=>	20,
	);
	$insert = [
		['name'	=>	'pater','age'	=>	30],
		['name'	=>	'xiaoming','age'	=>	20],
	]
	返回插入成功条数
	*/
	public function insert($data){
		//先判断是单挑插入还是多条插入
		if(is_array($data)){
			if(count($data) != count($data, 1)){//多条插入，二维数组
				$this->insertAll($data);
			}else{//单条插入
				$this->insertOne($data);
			}
			//return $this->query;
			return $this->conn(__FUNCTION__);
		}
	}
	//添加引号动作,修改变量的类型
	public function insertChangeValType($value){
		if(is_string($value)){
			return "'".$value."'";
		}else if(is_null($value)){
			return "''";
		}else{
			return $value;
		}
	}
	public function insertOne($data){
		// $func = function($value) {//添加引号动作
		// 	if(is_string($value)){
		// 		return "'".$value."'";
		// 	}else if(is_null($value)){
		// 		return "''";
		// 	}else{
		// 		return $value;
		// 	}
		// };
		$insert_key_str = $insert_val_str = "(";
		$insert_key_arr = array_keys($data);
		$insert_key_str .= implode($insert_key_arr,",");
		$insert_val_arr = array_values($data);
		$insert_val_arr = array_map(array($this, 'insertChangeValType'), $insert_val_arr);
		$insert_val_str .= trim(implode($insert_val_arr,","),",");
		$insert_key_str .= ")";
		$insert_val_str .= ")";
		$this->query = "INSERT INTO ".$this->table." ".$insert_key_str." VALUES ".$insert_val_str;
	}
	public function insertAll($data){
		$insert_key_str = "(";
		$insert_val_str = "";
		foreach ($data as $key => $value) {
			$insert_val_str_detail = "(";
			if($key == 0){
				$insert_key_arr = array_keys($value);
				$insert_key_str .= implode($insert_key_arr,",");
			}
			$insert_val_arr = array_values($value);
			$insert_val_arr = array_map(array($this, 'insertChangeValType'), $insert_val_arr);
			$insert_val_str_detail .= trim(implode($insert_val_arr,","),",");
			$insert_val_str_detail .= ")";
			$insert_val_str .= $insert_val_str_detail.",";
		}
		$insert_key_str .= ")";
		$insert_val_str = trim($insert_val_str,",");
		$this->query = "INSERT INTO ".$this->table." ".$insert_key_str." VALUES ".$insert_val_str;
	}
	public function update($data){
		if(is_array($data)){
			$update = "";
			foreach ($data as $key => $value) {
				if(is_numeric($value)){
					$update .= $key."=".$value.",";
				}else if(is_string($value) || empty($value)){
					$update .= $key."='".$value."',";
				}else{
					$update .= $key."=".$value.",";
				}
			}
			$update = trim($update,",");
			if(!empty($this->where)){
				$this->where = " WHERE ".$this->where;	
			}
			$this->query = "UPDATE ".$this->table." SET ".$update.$this->where;
			echo $this->query;
			exit;
		}
	}
	public function delete(){
		if(!empty($this->where)){
				$this->where = " WHERE ".$this->where;	
		}
		$this->query = "DELETE FROM ".$this->table.$this->where;
		echo $this->query;
		exit;
	}
	/*
	$where_arr['UID'] = 1;
	$where_arr['AGE'] = [">",20];
	$where_arr['NAME'] = "jack";
	$whereOr['UID'] = 2;
	$whereOr['AGE'] = ["<",20];
	支持$sql = $query->table("user")->where($where_arr,'and')->where($whereOr,"or")->group("id,name")->order("UID")->limit(10, 20)->select();
	$sql = $query->table("user")->where("UID=1 and AGE>20")->where("UID=2","OR")->select();
	*/
	//where类暂不支持in操作  
	//不支持 id=1 or id=2的操作
	//目前where方法还有很多地方需要优化修改，建议直接使用传where条件字符串的方式使用
	public function where($where_arr = [] ,$flag = "AND"){
		if(is_array($where_arr)){
			foreach ($where_arr as $key => &$value) {
				if(!is_array($value)){
					if(is_string($value)){
						$value = "'".$value."'";
					}
					$data[] = $key."=".$value;
				}else{
					list($sign,$val) = $value;
					if(is_string($val)){
						$val = "'".$val."'";
					}else if(is_array($val)){
						$val = implode(",",$val);
						$val = "(".trim($val,",").")";
					}
					$data[] = $key." ".$sign." ".$val;
				}
			}
			if(!empty($this->where)){//此处共有部分还可以继续优化
				$this->where .= strtoupper($flag)." (".implode($data," ".strtoupper($flag)." ").") ";
			}else{
				$this->where .= " (".implode($data," ".strtoupper($flag)." ").") ";
			}
		}else if(is_string($where_arr)){
			if(!empty($this->where)){
				$this->where .= strtoupper($flag)." (".$where_arr.") ";
			}else{
				$this->where .= " (".$where_arr.") ";
			}
		}
		return $this;
	}
	//注意要么都使用别名，要么都不用，只有个别表用别名可能会出问题(不确定程序是否有问题，可能mysql的机制就是如此)
	//支持
	// $join = [
	//     ['dept','dept.did=user.did'],
	//     ['priv','priv.priv_id=user.pid','left'],
	// ];
	// $sql = $query->table("user")->join($join)->select();
	// $join = [
	//     ['dept b','b.did=a.did'],
	//     ['priv c','c.priv_id=a.pid','left'],
	// ];
	// $sql = $query->table("user")->alias("a")->join($join)->count();
	// $sql = $query->table("user")->join("dept","dept.did=user.did")->select();
	// $sql = $query->table("user")->alias("a")->join("dept b","a.did=b.did")->select();
	// $sql = $query->table("user")->join("dept","dept.did=user.did","left/right/join/inner")->select();
	public function join($table ,$relevance="" ,$type="INNER"){
		if(!empty($table) && is_string($table)){
			$table_alias = explode(" ", $table);
			$table = implode(" AS ", $table_alias);
			$this->join .= " ".strtoupper($type)." JOIN ".$table." ON ".$relevance;
		}
		if(is_array($table)){
			foreach ($table as $value) {
				//如果value没有第三个参数，此处会有一个notice，提示未定义，还未解决
				@list($table_detail,$relevance_detail,$type_detail) = $value;
				if(!isset($type_detail) || empty($type_detail)){
					$type_detail = strtoupper($type);
				}
				$this->join($table_detail,$relevance_detail,$type_detail);
			}
		}
		return $this;
	}
	public function count($columns='*'){
		$columns = trim($columns,",");
		if(!empty($this->where)){
			$this->where = " WHERE ".$this->where;	
		}
		$this->query = "SELECT COUNT(".$columns.") FROM ".$this->table.$this->join.$this->where.$this->group.$this->order.$this->limit;
		return $this->query;
	}
	//尚未解决用别名的时候 后面的关联条件统一替换的问题

	public function conn($type,$query=""){
		$dataBaseInfo = APP::getConfig();
		$mysqlTypeName = "\lib\\db\\".ucfirst($dataBaseInfo['conntype'])."Conn";
		$data = new $mysqlTypeName();
		return $data->$type($this->query);
	}
}


 ?>