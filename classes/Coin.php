<?php

	class Coin {

		public $type = "";
		public $high;
		public $low;
		public $volume;
		public $last;
		public $base_volume;
		public $time;
		public $bid;
		public $ask;
		public $purchase_rate = 0;
		public $rates = [];
		public $pending_purchase_rate = 0;

		public $open_buy_order_count;
		public $open_sell_order_count;

		public $previous_day;
		public $created;

		// thse are going to need to make actual requests to see what orders have been made and not just amounts.
		public $open_buy_orders;
		public $open_sell_orders;

		public function __construct($type) {

			$request = new Request("public/getmarketsummary");
			$results = $request->getRequest(["market" => $type]);
			if($results->success != true) {
				throw new InvalidMarketPlaceException($results->message);
			}
			$result 						= $results->result[0];
			$this->type 					= $type;
			$this->high 					= $result->High;
			$this->low						= $result->Low;
			$this->volume 					= $result->Volume;
			$this->last						= $result->Last;
			$this->ask 						= $result->Ask;
			$this->bid 						= $result->Bid;
			$this->open_buy_order_count		= $result->OpenBuyOrders;
			$this->open_sell_order_count	= $result->OpenSellOrders;
			$this->previous_day				= $result->PrevDay;
			$this->created					= $result->Created;

		}

		public static function getTestCoins() {

			$coins = [];
			$coins[] = new Coin("btc-ada");
			$coins[] = new Coin("btc-ark");
			$coins[] = new Coin("btc-powr");

			return $coins;
		}

		public static function getAll() {
			$request = new Request("public/getmarketsummaries");
			$request_coins = $request->getRequest();
			if(!$request_coins->success) throw new Exception("Error retrieving coins");

			$coins = [];

			foreach ($request_coins->result as $c) {
				try {
					if(preg_match("/^BTC/", $c->MarketName) == true) {
						$coins[] = new Coin($c->MarketName);
						//echo "$c->MarketName added";
					}
				}
				catch(InvalidMarketPlaceException $e) {
					print_r($e->getMessage());
				}
				catch(Exception $e) {
					print_r($e->getMessage());
				}
			}

			return $coins;
		}

		public function addRate($rate) {
			if(!is_array($this->rates)) $this->rates = [];
			$rates = $this->rates;

			array_unshift($rates, $rate);

			if( count($rates) > 3600 ) array_pop($rates);

			$this->rates = $rates;
		}

		public function getDifference($new_rate, $minutes) {
			$seconds = $minutes * 10;
			if( !empty($this->rates[$seconds - 1]) ) {
				$old_rate = floatval($this->rates[$seconds - 1]);
				$percent = (($new_rate - $old_rate) / $old_rate) * 100;

				return $percent;
			}
			else return 0;
		}

		public function buy($qty, $rate) {
			//this status variable is to make sure that the purchase went through.
			$status = true;
			//$status = Market::buy($this->type, $qty, $rate);
			if($status) {
				$rate->setPurchaseRate($rate);
			}
			else {
				$rate->setPendingPurchaseRate($rate);
			}
			Notification::sendNotification($this->type, "Buy at $rate");

			// Log
			//Log::log($this->type, $rate, date("Y-m-d H:i:s"));
			exit(1);
		}

		public function sell($qty, $rate) {
			$status = true;
			//$status = Market::sell($this->type, $qty, $rate);
			if($status) {
				$rate->setPurchaseRate(0);
			}
			Notification::sendNotification($this->type, "Sell at $rate");

			// Log
			//Log::log($this->type, $rate, date("Y-m-d H:i:s"));
			exit(1);
		}


		public function getPurchaseRate() {
			return floatval($this->purchase_rate);
		}

		public function setPurchaseRate($rate) {
			if(floatval($rate) >= 0) {
				$this->purchase_rate = floatval($rate);
			}
			else {
				throw new Exception("Purchase rate is < 0");
			}
		}

		public function setPendingPurchaseRate($rate) {
			if(floatval($rate) >= 0) {
				$this->pending_purchase_rate = floatval($rate);
			}
			else {
				throw new Exception("Purchase rate is < 0");
			}
		}

	    public function getType() {
	        return $this->type;
	    }

	    public function getHigh() {
	        return $this->high;
	    }

	    public function getLow() {
	        return $this->low;
	    }

	    public function getVolume() {
	        return $this->volume;
	    }

	    public function getLast() {
	        return $this->last;
	    }

	    public function getLiveLast() {
	    	$request = new Request("public/getticker");
	    	$result = $request->getRequest(["market" => $this->type]);
	    	if(!$result->success) {
	    		throw new Exception("Marketplace Ticket not found");
	    	}
	        return $result->result->Last;
	    }

	    public function getBaseVolume() {
	        return $this->base_volume;
	    }

	    public function getTime() {
	        return $this->time;
	    }

	    public function getBid() {
	        return $this->bid;
	    }

	    public function getAsk() {
	        return $this->ask;
	    }

	    public function getOpenBuyOrderCount() {
	        return $this->open_buy_order_count;
	    }

	    public function getOpenSellOrderCount() {
	        return $this->open_sell_order_count;
	    }

	    public function getPreviousDay() {
	        return $this->previous_day;
	    }

	    public function getCreated() {
	        return $this->created;
	    }

	    public function getOpenBuyOrders() {
	        return $this->open_buy_orders;
	    }

	    public function getOpenSellOrders() {
	        return $this->open_sell_orders;
	    }
	}

?>