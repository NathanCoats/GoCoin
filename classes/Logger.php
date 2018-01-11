<?php

	class Logger {

		public $total = 0;
		public $percentage = 0;

		public static function getConnection() {
			$connection = new mysqli(Config::get("db_host"), Config::get("db_user"), Config::get("db_pass"), Config::get("db"));
			if($connection->connect_error) throw new Exception("Couldn't Connect $connection->connect_error");
			return $connection;
		}

		public function buildXMLFile() {
			$connection = self::getConnection();
			$active_coins = Config::get("active_coins");
			$coins = [];

			foreach($active_coins as $type => $coin) {

				$result = $connection->query('SELECT type, action, rate, qty, percent_difference FROM log WHERE type="' . $type . '" and date >= now() - INTERVAL 1 DAY ORDER BY date ASC');

				$itterations = 0;
				if($result->num_rows > 0) {
					while( $row = $result->fetch_assoc()) {
						$itterations++;
						$rate = (double)$row["rate"];
						$qty = (double)$row["qty"];
						$percent_difference = (double)$row["percent_difference"];
						$rate *= $qty;
						$type = $row["type"];
						$action = $row["action"];
						$amount = (empty($coins[$type]['amount'])) ? 0 : $coins[$type]['amount'];
						$percent = (empty($coins[$type]['percent'])) ? 0 : $coins[$type]['percent'];

						if($itterations === 1 && $action === "sell") continue;

						if($itterations == $result->num_rows && $action == "buy") continue;

						$fee_amount = $rate * .0005;
						$percent += $percent_difference;
						if($action === "buy") {
							$amount -= $rate;
							$amount -= $fee_amount;
						}
						else if($action === "sell") {
							$amount += $rate;
							$amount += $fee_amount;
						}
						$coins[$type]['amount'] = $amount;
						$coins[$type]['percent'] = $percent / count($active_coins);
					}
				}

			}

			$xml_string = "<?xml version='1.0' encoding='UTF-8' ?>\n<root>";

			//give a baseline
			$xml_string .= "\n\t<item>";
			$xml_string .= "\n\t\t<coin>Baseline</coin>";
			$xml_string .= "\n\t\t<gain>" . number_format(1, 4) . "</gain>";
			$xml_string .= "\n\t</item>";

			foreach ($coins as $index => $coin) {
				//$c = new Coin($index);
				//$last = $c->getLast();
				$this->total += $coin['amount'];
				$this->percentage += $coin['percent'];

				$xml_string .= "\n\t<item>";
				$xml_string .= "\n\t\t<coin>$index</coin>";
				$xml_string .= "\n\t\t<gain>" . number_format($coin['percent'], 4) . "</gain>";
				$xml_string .= "\n\t</item>";
			}

			$xml_string .= "\n</root>";

			$path = getBasePath();
			$file = fopen($path . DS . "data.xml", "w");
			fputs($file, $xml_string);
			fclose($file);

			$connection->close();
		}

		public function getTotal() {
			return $this->total;
		}

		public function getPercentage() {
			return $this->percentage;
		}

		public static function log($type, $rate, $percent_difference = 0, $qty = 1, $action = "buy") {
			$connection = self::getConnection();
			$action = strtolower($action);
			$date = date("Y-m-d H:i:s");
			$qty = intval($qty);
			$stmt = $connection->prepare("INSERT INTO log (type, rate, action, date, qty, percent_difference) VALUES(?, ?, ?, ?, ?, ?)");
			if(!$stmt) {
				throw new Exception("Prepare Statement failed: " . $connection->error);
			}
			if (!$stmt->bind_param("ssssid", $type, $rate, $action, $date, $qty, $percent_difference)) {
				throw new Exception("Binding parameters failed: " . $stmt->error);
			}

			if( !$stmt->execute() ) {
			   throw new Exception("Execute failed: " . $stmt->error);
			}

			$connection->close();

		}
	}

?>
