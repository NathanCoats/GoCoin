<?php

	require __DIR__ . '/vendor/autoload.php';

	try {

		$ada_high = 0.00001250;
		$ada_low = 0.00001100;

		// $powr_high = 0.00006600;
		// $powr_low = 0.00006400;

		

		while(true) {
			$ada_coin = new Coin("btc-ada");
			//$powr_coin = new Coin("btc-powr");
			$ada_rate = $ada_coin->getLast();
			//$powr_rate = $powr_coin->getLast();

			if($ada_rate >= $ada_high || $ada_rate <= $ada_low) {
				Notification::sendNotification("ada", "ada is $ada_rate");
				exit(1);
			} 
			// if($powr_rate >= $powr_high) {
			// 	Notification::sendNotification("powr", "powr is $powr_rate");
			// 	exit(1);
			// } 
			sleep(3);
		}
 
		dd("Done");
		// $interesting_markets = [
		// 	"BTC-POWR",
		// 	"BTC-XVG",
		// 	"BTC-EMC2",
		// 	"BTC-DASH",
		// 	"BTC-VTC",
		// 	"BTC-ZEC",
		// ];

		// foreach (getMarkets() as $market) {
		// 	$coin = new Coin($market->MarketName);
		// 	dd($coin);
		// }

		// $market = "btc-ada";
		// // get a coin current market value
		// $coin = new Coin($market);

		// $quantity = 45;
		// $rate = $coin->getLast();

		// //$result = Market::sell($market, $quantity, $rate);
		// //$result = Market::buy($market, $quantity, $rate);

		// dd($result);
	}
	catch(Exception $e) {
		dd($e);
	}

?>