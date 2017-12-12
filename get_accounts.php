<?php

	require __DIR__ . '/vendor/autoload.php';

	try {
		$balances = Account::getBalances();
		foreach($balances as $balance) {
			if($balance->Currency !== "BTC") {
				$rate = Account::getPurchaseRate("BTC-$balance->Currency");
				$current_rate = Coin::getLiveRate("BTC-$balance->Currency");
				$diff = getPercentDifference($current_rate, $rate);
				$gain = number_format($rate + ($rate * .05), 8);
				echo "$balance->Currency: Purchase Rate:" . number_format($rate, 8) . " CurrentRate: " . number_format($current_rate, 8) . " Percent Difference: " . number_format($diff, 5) . " 5% Gain: $gain\n";
			}

		}
	}
	catch(Exception $e) {
		dd($e);
	}

?>