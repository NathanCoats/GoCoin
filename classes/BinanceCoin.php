<?php

	class BinanceCoin {

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
		public $high_percentage = 0;
		public $low_percentage = 0;
		public $time_limits;
		public $run_high;
		public $rates = [];
		public $pending_purchase_rate = 0;
		public $buy_uuid = "";
		public $sell_uuid = "";

		public $open_buy_order_count;
		public $open_sell_order_count;

		public $previous_day;
		public $created;

		// // thse are going to need to make actual requests to see what orders have been made and not just amounts.
		// public $open_buy_orders;
		// public $open_sell_orders;

		public function __construct($type) {
			$type = strtoupper($type);
			
			$request = new Request("ticker/24hr");
			$result = $request->getRequest(["symbol" => $type]);
			if(empty($result->lastPrice)) throw new InvalidMarketPlaceException($type);
			

			$this->type 					= $type;
			$this->last						= $result->lastPrice;
			$this->high 					= $result->highPrice;
			$this->low						= $result->lowPrice;
			$this->volume 					= $result->volume;
			$this->ask 						= $result->askPrice;
			$this->bid 						= $result->bidPrice;
			//$this->open_buy_order_count		= $result->OpenBuyOrders;
			//$this->open_sell_order_count	= $result->OpenSellOrders;
			//$this->previous_day				= $result->PrevDay;
			//$this->created					= $result->Created;

			$active_coins = Config::get("active_coins");

			// if( floatval($high_percentage) < 2) throw new Exception("High Percent Must be above 2");
			// if( floatval($low_percentage) < 2) throw new Exception("Low Percent Must be above 2");

			// todo validate these configurations
			$type = strtolower($type);
			$this->time_limits				= $active_coins[$type]->time_limits;
			$this->low_percentage			= floatval($active_coins[$type]->low_percentage);
			$this->high_percentage			= floatval($active_coins[$type]->high_percentage);

		}

		public function getTimeLimits() {
			return $this->time_limits;
		}

		public static function getTestCoins() {

			$coins = [];
			$active_coins = Config::get("active_coins");

			foreach ($active_coins as $name =>  $coin) {
				$coins[] = new BinanceCoin($name);
			}

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
						$coins[] = new BinanceCoin($c->MarketName);
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

				return getPercentDifference($new_rate, $old_rate);

			}
			else return 0;
		}

		public function getPast($minutes) {
			$seconds = $minutes * 10;
			if( !empty($this->rates[$seconds - 1]) ) {
				$old_rate = floatval($this->rates[$seconds - 1]);
				return $old_rate;
			}
			else return 0;
		}

		public function markBought($rate, $uuid = "") {
			$this->setRunHigh($rate);
			$this->setPurchaseRate($rate);
			$this->setBuyUUID($uuid);
		}

		public function markSold($uuid = "") {
			$this->setRunHigh(0);
			$this->setSellUUID($uuid);
			$this->setPurchaseRate(0);
			$this->rates = [];
		}

		public function buy($qty, $rate) {
			//this status variable is to make sure that the purchase went through.
			$uuid = true;

			//$uuid = Market::buy($this->type, $qty, $rate);
			if($uuid) {
				$this->markBought($rate, $uuid);
			}

			else {
				$this->setPendingPurchaseRate($rate);
			}

		}

		public function sell($qty, $rate) {
			//this status variable is to make sure that the purchase went through.
			$uuid = true;

			//$uuid = Market::sell($this->type, $qty, $rate);
			if($uuid) {
				$this->markSold($uuid);
			}

		}


		public function getPurchaseRate() {
			return floatval($this->purchase_rate);
		}

		public function getHighPercentage() {
			return floatval($this->high_percentage);
		}

		public function getLowPercentage() {
			return floatval($this->low_percentage);
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

        public function getBuyUUID() {
        	return $this->buy_uuid;
        }

        public function setBuyUUID($uuid) {
            $this->buy_uuid = $uuid;
        }

        public function getSellUUID() {
            return $this->sell_uuid;
        }

        public function setSellUUID($uuid) {
            $this->sell_uuid = $uuid;
        }

	    public function getRunHigh() {
	        return $this->run_high;
	    }

		public function setRunHigh($run_high) {
	    	$this->run_high = (double)$run_high;
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
	    	$request = new Request("ticker/24hr");
	    	$result = $request->getRequest(["symbol" => $this->type]);
	    	if( empty($result->lastPrice) ) {
	    		throw new Exception("Marketplace Ticket not found: $result->message");
	    	}

	        return $result->lastPrice;
	    }

	    public static function getLiveRate($type) {
	    	$request = new Request("ticker/24hr");
	    	$result = $request->getRequest(["symbol" => $this->type]);
	    	if( empty($result->lastPrice) ) {
	    		throw new Exception("Marketplace Ticket not found: $result->message");
	    	}

	        return $result->lastPrice;
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
