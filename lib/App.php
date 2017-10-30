<?php 
namespace lib;

class App
{
	public static function run()
	{
		//echo $_SERVER['REQUEST_URI'];
		//此处还未实现如何隐藏index.php功能
		$arr = explode("index.php",$_SERVER['REQUEST_URI']);
		$mvc_path = array_pop($arr);
		$mvc_path_arr = explode("/",trim($mvc_path,"/"));
		@list($app,$class,$function) = $mvc_path_arr;
		$root_path = getcwd()."/";
		if(!file_exists($root_path."app/".$app)){
			exit($app."模块未发现");
		}else if(!file_exists($root_path."app/".$app."/Controller/".$class.".php")){
			exit($app."模块下".$class."控制器未发现");
		}else{
			//echo "app/".$app."/Controller/".$class;
			//require "/app/user/Controller/Index.php";
			$require_class = "\app\\".$app."\Controller\\".ucfirst($class);
			$class_check = new $require_class;
			$check_method = method_exists($class_check,$function);
			if(!$check_method){
				exit($app."模块下".$class."控制器下未发现方法".$function);
			}else{
				$data = $class_check->$function();
				if(is_array($data)){
					print_r($data);
				}else if(is_string($data)){
					echo $data;
				}else{
					print_r($data);
				}
			}
		}
	}
}



 ?>