<?php 
namespace lib;

class Loader
{
	public static function autoload($class){
		$class = str_replace('\\','/', $class);
		$file = $class.".php";
		if(file_exists($file)){
			require_once($file);
		}
	}
	public static function register($autoload = ''){
		spl_autoload_register("lib\\Loader::autoload");
	}
}



 ?>