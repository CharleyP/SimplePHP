<?php 
/**
* 用户类
*/
class User
{
	
	protected $uid;

	function __construct($myselft = true)
	{
		if($myself && empty($this->uid)){
			$this->uid = $_SESSION['uid'];
		}
	}
	public function getUserData(){
		
	}
}

 ?>