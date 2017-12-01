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
				throw new Exception($result->message);
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