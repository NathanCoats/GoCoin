<?php

	class Logger {

		public static function getConnection() {
			$connection = new mysqli(Config::get("db_host"), Config::get("db_user"), Config::get("db_pass"), Config::get("db"));
			if($connection->connect_error) throw new Exception("Couldn't Connect $connection->connect_error");
			return $connection;
		}

		public static function log($type, $rate, $action) {
			$action = strtolower($action);
			$connection = self::getConnection();
			$stmt = $connection->prepare("INSERT INTO log (type, rate, action) VALUES(?, ?, ?)");
			if(!$stmt) {
				throw new Exception("Prepare Statement failed: " . $connection->error);
			}
			if (!$stmt->bind_param("sss", $type, $rate, $action)) {
				throw new Exception("Binding parameters failed: " . $stmt->error);
			}

			if( !$stmt->execute() ) {
			   throw new Exception("Execute failed: " . $stmt->error);
			}

			$connection->close();

		}
	}

?>
