<?php 
namespace lib;

use lib\Request;

class App
{
	public static $request = [];
	public static $module;
	public static $controller;
	public static $action;

	public static function run()
	{
		self::checkUrl();
	}
	//获取URL各参数
	public static function checkUrl(){
		//此处还未实现如何隐藏index.php功能
		$arr = explode("index.php",$_SERVER['REQUEST_URI']);
		$mvc_path = array_pop($arr);
		$mvc_path_arr = explode("/",trim($mvc_path,"/"));
		//获取应用目录/控制器/方法
		self::$module = array_shift($mvc_path_arr);
		self::$controller = array_shift($mvc_path_arr);
		self::$action = array_shift($mvc_path_arr);
		$request_url = implode("|",$mvc_path_arr);
		//正则获取URL参数
		if(!empty($request_url)){
			preg_replace_callback("/(\w+)\|([^\|])/", function($match) use (&$val){
				$val[$match[1]] = $match[2];
			}, $request_url);
			self::$request = $val;
			unset($val);
		}
		self::checkPath();
	}
	//检测路径合法性
	public static function checkPath(){
		$root_path = getcwd()."/";
		if(!file_exists($root_path."app/".self::$module)){
			exit(self::$module."模块未发现");
		}else if(!file_exists($root_path."app/".self::$module."/Controller/".self::$controller.".php")){
			exit(self::$module."模块下".self::$controller."控制器未发现");
		}else{
			$require_controller = "\app\\".self::$module."\Controller\\".ucfirst(self::$controller);
			$controller = new $require_controller;
			$check_method = method_exists($controller,self::$action);
			if(!$check_method){
				exit(self::$module."模块下".self::$controller."控制器下未发现方法".self::$action);
			}else{
				self::getData($controller, self::$action);
			}
		}
	}
	public static function getData($class, $action){
		$data = $class->$action(new Request(self::$request));
		if(is_array($data)){
			print_r($data);
		}else if(is_string($data)){
			echo $data;
		}else{
			print_r($data);
		}
	}
}



 ?>