<?php 

class DBChoiceFactory
{
	const DB_TYPE_MYSQL = "mysql";
	const DB_TYPE_ORACLE = "oracle";
	private static $db_choice = null;

	public static function factory($db_type){
		if(self::$db_choice == null){
			switch ($db_type) {
				case self::DB_TYPE_MYSQL:
					self::$db_choice = MySQLConn::create();
					break;
				case self::DB_TYPE_ORACLE:
					self::$db_choice = OracleConn::create();
					break;
				default:
					self::$db_choice = MySQLConn::create();
					break;
			}
		}
		return self::$db_choice;
	}
}

 ?>