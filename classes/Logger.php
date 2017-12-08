<?php

	class Logger {

		public static function getConnection() {
			$connection = new mysqli(Config::get("db_host"), Config::get("db_user"), Config::get("db_pass"), Config::get("db"));
			if($connection->connect_error) throw new Exception("Couldn't Connect $connection->connect_error");
			return $connection;
		}

		public static function buildXMLFile() {
			$connection = self::getConnection();

			$result = $connection->query("SELECT * FROM log WHERE date >= now() - INTERVAL 1 DAY;");
			$coins = [];
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			    	$rate = (double)$row["rate"];
			    	$qty = (double)$row["qty"];
			    	$type = $row["type"];
			    	$action = $row["action"];
			    	$amount = (empty($coins[$type])) ? 0 : $coins[$type];

			    	if($action === "buy") {
			    		$amount -= ($rate * .0025);
			    	}
			    	else if($action === "sell") {
			    		$amount += ($rate * .0025);
			    	}

			    	$coins[$type] = $amount;
			    }
			}

			$xml_string = "<?xml version='1.0' encoding='UTF-8' ?>\n<root>";

			//give a baseline
			$xml_string .= "\n\t<item>";
			$xml_string .= "\n\t\t<coin>Baseline</coin>";
			$xml_string .= "\n\t\t<gain>" . number_format(0, 12) . "</gain>";
			$xml_string .= "\n\t</item>";

			foreach ($coins as $index => $coin) {
				//$c = new Coin($index);
				//$last = $c->getLast();

				$xml_string .= "\n\t<item>";
				$xml_string .= "\n\t\t<coin>$index</coin>";
				$xml_string .= "\n\t\t<gain>" . number_format($coin, 12) . "</gain>";
				$xml_string .= "\n\t</item>";
			}

			$xml_string .= "\n</root>";

			$path = getBasePath();
			$file = fopen($path . DS . "data.xml", "w");
			fputs($file, $xml_string);
			fclose($file);

			$connection->close();
		}

		public static function log($type, $rate, $qty = 1, $action = "buy") {
			$connection = self::getConnection();
			$action = strtolower($action);
			$date = date("Y-m-d H:i:s");
			$qty = intval($qty);
			$stmt = $connection->prepare("INSERT INTO log (type, rate, action, date, qty) VALUES(?, ?, ?, ?, ?)");
			if(!$stmt) {
				throw new Exception("Prepare Statement failed: " . $connection->error);
			}
			if (!$stmt->bind_param("ssssi", $type, $rate, $action, $date, $qty)) {
				throw new Exception("Binding parameters failed: " . $stmt->error);
			}

			if( !$stmt->execute() ) {
			   throw new Exception("Execute failed: " . $stmt->error);
			}

			$connection->close();

		}
	}

?>
