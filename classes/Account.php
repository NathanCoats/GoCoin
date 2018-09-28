<?php

	class Account {

		public static function getOpenOrders($market, $quantity, $rate) {

		}

		public static function getPurchaseRate($currency) {
			$orders = Account::getOrderHistory($currency);

			// this just get the last purchase you made.
			// TODO THIS NEEDS TO INCLUDE ALL THE LAST PURCHASES THAT YOU MADE.
			foreach ($orders as $order) {
				if($order->OrderType === "LIMIT_BUY" ) return  floatval($order->PricePerUnit);
			}
			return 0;
		}

		public static function getOrderHistory($market) {
			$request = new Request("account/getorderhistory");
			$results = $request->getRequest(["market" => $market], true);
			if(!$results->success) throw new Exception("Unable to get Order History for $market: " . $results->message);
			$result_set = $results->result;
			usort($result_set, function($a, $b){
				return $a->TimeStamp < $b->TimeStamp;
			});
			return $result_set;
		}

		public static function getBalances($with_dust = false) {
			$request = new Request("account/getbalances");
			$results = $request->getRequest([], true);
			if(!$results->success) throw new Exception("Unable to get Balances");

			$balances = [];
			foreach ($results->result as $result) {
				if($result->Balance > .0000001) $balances[] = $result;
			}
			return $balances;
		}

		public static function getAvailable($currency) {
			$balance = Account::getBalance($currency);
			return $balance->Available;
		}

		public static function getBalance($currency = "BTC") {
			return 0;
			$currency = strtoupper($currency);
			if(preg_match("/^BTC-.{2,5}$/", $currency)) {
				$currency = substr($currency, 4);
			}

			$request = new Request("account/getbalance");
			$results = $request->getRequest(["currency" => $currency], true);

			if(!$results->success) throw new Exception("Unable to get Balance $currency:");
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
