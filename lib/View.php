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
			$this->module = APP::$module;
		}
		if(empty($this->action)){
			$this->action = APP::$action;
		}
		if(empty($this->controller)){
			$this->controller = APP::$controller;
		}
	}
	public function getViewData(){

		$view_path = getcwd()."/"."app/".$this->module."/View/".$this->action.".html";
		$data = file_get_contents($view_path);
		return $data;
	}
	public function assign($variable ,$value){
		$view_data = $this->getViewData();
		$view_data = preg_replace("/{{[\s\w\$]+}}/","<?php echo \$value; ?>",$view_data);
		$cache_name = md5($this->module.$this->controller.$this->action).".php";
		$root_path = getcwd()."/";
		if(!file_exists($root_path."cache/".$this->module)){
			mkdir($root_path."cache/".$this->module,0777);
		}
		//输出缓存文件
		file_put_contents($root_path."cache/".$this->module."/".$cache_name, $view_data);


		//$data = file_get_contents("");

		$test = "<!DOCTYPE html>
				<html>
				<head>
					<title></title>
				</head>
				<body>
				<div><?php echo 'SELECT UID,EID,PHONE FROM p101' ?></div>
				</body>
				</html>";
		// eval("\$test = \"$test\";");
		echo $test;
		exit;
	}
}



 ?>