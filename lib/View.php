<?php 
namespace lib;

use lib\App;

class View
{
	public $module;
	public $action;
	public $template;
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
	public function getTemplate(){

		$view_path = getcwd()."/"."app/".$this->module."/View/".$this->action.".html";
		$data = file_get_contents($view_path);
		return $data;
	}
	public function assign($variable ,$value){
		$this->template[$variable] = $value;
	}
	public function fetch(){
		$root_path = getcwd()."/";
		$cache_name = md5($this->module.$this->controller.$this->action).".php";
		$cacheFile = $root_path."cache/".$this->module."/".$cache_name;
		if(!file_exists($cacheFile)){
			$template_data = $this->getTemplate();
			$view_data = preg_replace("/{{[\s]+/","<?php echo ",$template_data);
			$view_data = preg_replace("/[\s]+}}/","; ?>",$view_data);
			//输出模板缓存文件
			file_put_contents($cacheFile, $view_data);
		}
		// 页面缓存
        ob_start();
        ob_implicit_flush(0);
        // 读取编译存储
		if (!empty($this->template) && is_array($this->template)) {
            // 模板阵列变量分解成为独立变量
            extract($this->template, EXTR_OVERWRITE);
        }
        //载入模版缓存文件
        include $cacheFile;
		// 获取并清空缓存
        $content = ob_get_clean();
		echo $content;
	}
}



 ?>