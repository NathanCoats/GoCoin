<?php

	class Request {

		//public $base_url = "https://bittrex.com/api";
		public $base_url = "https://www.binance.com/api";
		public $uri = "";
		public $url = "";
		public $version = "";

		private $secret = "";
		private $key = "";

		public function __construct($uri) {

			$this->uri = $uri;
			$this->version = "v1";
			$this->url = "$this->base_url/$this->version/$this->uri";
			
			$this->secret = Config::get("secret");
			$this->key = Config::get("key");

		}

		public function getRequest($data = [], $include_api = false, $disable_ssl = true) {

			if($include_api === true) {
				$data["nonce"] = time();
				$data["apikey"] = $this->key;
			}

			$url = $this->url . "?" . http_build_query($data);
			$sign = hash_hmac('sha512', $url, $this->secret);
			
			$ch  =  curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("apisign:$sign"));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			if($disable_ssl === true) {
			    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			}
			$result = curl_exec($ch);
			$error = curl_error($ch);

			if(!empty($error)) throw new Exception($error);
			
			curl_close($ch);

			$obj = json_decode($result);
			return $obj;


		}

	}


?>