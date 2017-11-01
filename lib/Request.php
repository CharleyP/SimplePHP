<?php 
namespace lib;

class Request
{

	protected $request;
	public function __construct($request){
		if(empty($this->request)){
			$this->request = $request;
		}
	}
	public function param($key = ""){
		if(!array_key_exists($key,$this->request)){
			return false;
		}
		if(empty($key)){
			return $this->request;
		}else{
			return $this->request[$key];
		}
	}
}


 ?>