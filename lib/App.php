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
		//获取应用目录/控制器/方法
		$app = array_shift($mvc_path_arr);
		$class = array_shift($mvc_path_arr);
		$function = array_shift($mvc_path_arr);
		$request_url = implode("|",$mvc_path_arr);
		//正则获取URL参数
		preg_replace_callback("/(\w+)\|([^\|])/", function($match) use (&$val){
			$val[$match[1]] = $match[2];
		}, $request_url);


		//@list($app,$class,$function) = $mvc_path_arr;
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