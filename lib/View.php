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
		$template_data = $this->getTemplate();
		$value = "sql";
		$root_path = getcwd()."/";
		$cache_name = md5($this->module.$this->controller.$this->action).".php";
		/*foreach ($this->template as $key => $value) {
			$view_data = preg_replace("/{{[\s]+($".$key.")[\s]+}}/","<?php echo $$key; ?>",$template_data);
		}*/
		$view_data = preg_replace("/{{[\s]+/","<?php echo ",$template_data);
		$view_data = preg_replace("/[\s]+}}/","; ?>",$view_data);
		
		file_put_contents($root_path."cache/".$this->module."/".$cache_name, $view_data);
		$cacheFile = $root_path."cache/".$this->module."/".$cache_name;
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