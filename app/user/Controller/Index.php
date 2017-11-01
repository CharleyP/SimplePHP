<?php 
namespace app\user\Controller;

use lib\db\Query;
use lib\Request;
use lib\Controller;
use lib\View;

class Index extends Controller
{
	public function index(Request $request)
	{
		//print_r($request->param('qe'));
		//$request = Request::instance();
		//echo $request->param();
		//exit;

		$query = new Query();
		$sql = $query->table("p101")->select("UID,EID,PHONE");
		// ob_start();
		// echo $sql;
		// $data = ob_get_contents();
		// file_put_contents($_SERVER['DOCUMENT_ROOT']."/SimplePHP/cache/text.html", $data);
		// ob_end_flush();
	}
	public function test(){
		$data = "zzzzz";
		$test = "qqqqimgimgsdfsfimgimgqqqq";
		$test1 = preg_replace("/img{2}/","zzzzzzzz",$test);
		echo $test1;
		exit;
		$data = "qwer";
		$test = "1234{{$data}}9";
		$test1 = preg_replace("/^(\{){2}(.*)(\}){2}$/","<?php echo $data; ?>",$test);
		echo $test1;
		exit;

		$view = new View();
		$query = new Query();
		$sql = $query->table("p101")->select("UID,EID,PHONE");
		$view->assign("sql",$sql);
	}
}

 ?>