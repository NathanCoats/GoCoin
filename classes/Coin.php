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
		public $sell_percentage = 0;
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

		public function __construct($type, $sell_percentage = 2) {

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

			if( floatval($sell_percentage) < 2) throw new Exception("Sell Percent Must be above 2");
		
			$this->sell_percentage			= floatval($sell_percentage);

		}

		public static function getTestCoins() {

			$coins = [];
			$active_coins = Config::get("active_coins");

			foreach ($active_coins as $coin) {
				$coins[] = new Coin($coin->name, $coin->sell_percentage);
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

		public function getSellPercentage() {
			return floatval($this->sell_percentage);
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
