<?php 
namespace lib;

use lib\App;

class View
{
	public $module;
	public $action;
	function __construct()
	{
		if(empty($this->module)){
			$module = APP::$module;
		}
		if(empty($this->action)){
			$action = APP::$action;
		}
	}
	public function getViewData(){
		$view_path = getcwd()."/"."app/".$this->module."/View/".$this->action.".html";
		$data = file_get_contents($view_path);
		return $data;
	}
	public function assign($variable ,$value){
		$view_data = $this->getViewData();
		$test = "1234{{ $data }}9";
		$view_data = preg_replace("/{{(\s+)*(\s+)}}/","qqqqq",$view_data);
		echo $test1;
		exit;
	}
}



 ?>