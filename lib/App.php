<?php 
namespace lib;

use lib\Request;

class App
{
	public static $request = [];
	public static $module;
	public static $controller;
	public static $action;
	public static $config = [];

	public static function run()
	{
		self::checkUrl();
	}
	//获取URL各参数
	public static function checkUrl(){
		//此处还未实现如何隐藏index.php功能
		$mvc_path_arr = explode("/",trim($_SERVER['PATH_INFO'],"/"));
		//获取应用目录/控制器/方法
		list(self::$module,self::$controller,self::$action) = $mvc_path_arr;
		self::checkPath();
		//$request_url = $_SERVER['QUERY_STRING'];

		//正则获取URL参数
		$url_match = array_slice($mvc_path_arr,3);
		if(!empty($url_match)){
			$url_match = implode("|",$url_match);
			preg_replace_callback("/(\w+)\|([^\|])/", function($match) use (&$val){
				$val[$match[1]] = $match[2];
			}, $url_match);
			self::$request = $val;
			unset($val);
		}else{
			if(!empty($_GET)){
				array_push(self::$request,$_GET);
			}
			if(!empty($_POST)){
				array_push(self::$request,$_POST);
			}
		}
		
	}
	//检测路径合法性
	public static function checkPath(){
		self::getConfig();
		$root_path = self::$config['ROOT_PATH'];
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
	public static function getConfig(){
		self::$config = include "./config.php";
		return self::$config;
	}
}



 ?>