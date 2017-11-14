<?php 

return [
	//默认配置可不动
	"VIEW_FILE_TYPE"		=>	".html",
	"TEMPLET_SIGN_LEFT"		=>	"{{",
	"TEMPLET_SIGN_RIGHT"	=>	"}}",
	
	//项目目录
	"ROOT_PATH"				=>	$_SERVER['DOCUMENT_ROOT']."/simplePHP/",
	// MySQL类型
    'conntype'            => 'mysqli',//请选择mysql/Mysql、mysqli/Mysqli、PDO(请勿使用小写)
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'test',
    // 用户名
    'username'        => 'root',
    // 密码
    'password'        => 'root',
    // 端口
    'hostport'        => '3306',
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
]



 ?>