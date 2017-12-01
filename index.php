<?php

	require __DIR__ . '/vendor/autoload.php';

	try {


		foreach (getMarkets() as $market) {
			$coin = new Coin($market->MarketName);
			dd($coin);
		}

		$market = "btc-ada";
		// get a coin current market value
		$coin = new Coin($market);

		$quantity = 45;
		$rate = $coin->getLast();

		//$result = Market::sell($market, $quantity, $rate);
		//$result = Market::buy($market, $quantity, $rate);

		dd($result);
	}
	catch(Exception $e) {
		dd($e);
	}

?>