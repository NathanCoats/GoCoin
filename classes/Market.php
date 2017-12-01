<?php
	
	class Market {

		public static function sell($market, $quantity, $rate) {
			
			$request = new Request("market/selllimit");
			
			$total = $quantity * $rate;
			$min = 0.00050000;
			if($total < $min) throw new Exception("Min Sell Qty not met. total:$total");

			$data = [
				"market"	=> $market,
				"quantity"	=> $quantity,
				"rate"		=> $rate
			];


			return $request->getRequest($data, true);
		}

		public static function buy($market, $quantity, $rate) {
			
			$request = new Request("market/buylimit");
			$total = $quantity * $rate;
			$min = 0.00050000;
			if($total < $min) throw new Exception("Min Buy Qty not met. total:$total");

			$data = [
				"market"	=> $market,
				"quantity"	=> $quantity,
				"rate"		=> $rate
			];


			return $request->getRequest($data, true);
		}

	}

?>