<?php

	class Account {

		public static function getOpenOrders($market, $quantity, $rate) {

		}

		public static function getBalances() {
			$request = new Request("account/getbalances");
			$results = $request->getRequest([], true);
			if(!$results->success) throw new Exception("Unable to get Balances");
			return $results->result;
		}

		public static function getBalance($currency = "BTC") {
			$currency = strtoupper($currency);
			if(preg_match("/^BTC-.{2,5}$/", $currency)) {
				$currency = substr($currency, 4);
			}

			$request = new Request("account/getbalance");
			$results = $request->getRequest(["currency" => $currency], true);

			if(!$results->success) throw new Exception("Unable to get Balance $currency: " . $results->message);
			return $results->result;
		}


		public static function getOrder($uuid) {
			$request = new Request("account/getorder");
			$results = $request->getRequest(["uuid" => $uuid], true);
			if(!$results->success) throw new Exception("Unable to get Balances: " . $results->message);

			return $results->result;
		}

	}

?>
