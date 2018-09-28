<?php
	
	class BittrexMarket {

		public static function sell($market, $quantity, $rate) {
			if($qty <= 0) return false;
			$request = new Request("market/selllimit");
			
			$total = $quantity * $rate;
			$min = 0.00050000;
			if($total < $min) throw new Exception("Min Sell Qty not met. total:$total");

			$data = [
				"market"	=> $market,
				"quantity"	=> $quantity,
				"rate"		=> $rate
			];

			$result = $request->getRequest($data, true);
			if($result->success) {
				return $result->result->uuid;
			}
			
			return false;
		}

		public static function buy($market, $quantity, $rate) {
			if($qty <= 0) return false;
			
			$request = new Request("market/buylimit");
			$total = $quantity * $rate;
			$min = 0.00050000;
			if($total < $min) throw new Exception("Min Buy Qty not met. total:$total");

			$data = [
				"market"	=> $market,
				"quantity"	=> $quantity,
				"rate"		=> $rate
			];

			$result = $request->getRequest($data, true);
			if($result->success) {
				return $result->result->uuid;
			}
			
			return false;

		}

	}

?>