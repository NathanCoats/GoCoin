<?php

	class Config {

		public static $config_file = "config.php";

		public static function get($value) {
			$file_name = getBasePath() . DS . self::$config_file;
			$values = include $file_name;
			return ( !empty($values[$value]) ) ? $values[$value] :  "";
		}

		public static function has($value) {
			$file_name = getBasePath() . DS . self::$config_file;
			$values = include $file_name;
			return ( !empty($values[$value]) );
		}
		
	}

?>