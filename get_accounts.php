<?php

	require __DIR__ . '/vendor/autoload.php';

	while(true) {
		
		try {
			$balances = Account::getBalances();
			foreach($balances as $balance) {
				if($balance->Currency !== "BTC") {
					$rate = Account::getPurchaseRate("BTC-$balance->Currency");
					$available = Account::getAvailable("BTC-$balance->Currency");
					$current_rate = Coin::getLiveRate("BTC-$balance->Currency");
					$diff = getPercentDifference($current_rate, $rate);
					$gain = number_format($rate + ($rate * .05), 8);
					if($diff > 5) Notification::sendText($balance->Currency, " Is " . number_format($diff,2) . "% over what you put in.");
					echo "$balance->Currency: Purchase Rate:" . number_format($rate, 8) . " CurrentRate: " . number_format($current_rate, 8) . " Percent Difference: " . number_format($diff, 5) . " 5% Gain: $gain\n";
				}

			}
		}
		catch(Exception $e) {
			dd($e);
		}
		sleep(5);
	}

?>