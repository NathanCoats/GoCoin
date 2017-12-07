<?php

	require __DIR__ . '/vendor/autoload.php';

	try {

		//$coins = Coin::getAll();
		$coins = Coin::getTestCoins();
		if(!is_array(Config::get("percentages"))) throw new Exception("config.percentages must be defined as an array");
		while(true) {


			foreach($coins as $coin) {
				$rate = $coin->getLiveLast();
				$coin->addRate($rate);

				$rate = number_format($rate, 8);
				$rate = (float)$rate;

				$percentages = Config::get("percentages");


				foreach ($percentages as &$percent) {
					$percent->difference = $coin->getDifference($rate, $percent->minutes);
				}

				$purchase_rate = $coin->getPurchaseRate();


				// Buy Block
				if($purchase_rate <= 0) {

					try {		
						$balance = Account::getBalance();
						if((double)$balance->Available <= 0) {
							$qty = 0;
							//throw new Exception("Nothing In Your BTC Wallet");
						}
						else {
							$qty = (double)$balance->Available / 2;
						}
					}
					catch(Exception $e) {
						$qty = 0;
					}

					foreach ($percentages as $percent) {
						if( $percent->difference >= $percent->percent ) {

							if( Config::get("mode") === "log" ) {
								Logger::log($coin->getType(), $rate, "buy");
							}
							else if( Config::get("mode") === "notify" ){
								Notification::sendNotification(
									$coin->getType(),
									"Buy at " . number_format($rate, 8) . " which should be $percent->percent over " . number_format($coin->getRunHigh(), 8)
								);
							}
							else if (Config::get("mode") === "buy") {
								$coin->buy($qty, $rate);
							}
							else {
								throw new Exception("Invalid mode type selected");
							}

						}
					}

				}


				// Sell Block
				else if($purchase_rate > 0 ) {

					if( $rate > $coin->getRunHigh() ) {
						$coin->setRunHigh($rate);
					}

					$diff_percent = getPercentDifference($rate, $coin->getRunHigh());

					try {

						$balance = Account::getBalance($coin->getType());
						if((double)$balance->Available <= 0) {
							// verify that the order was placed properly
							throw new Exception("Nothing In Your Wallet");
						}

						$qty = (double)$balance->Available;
					}
					catch(Exception $e) {
						$qty = 0;
					}

					$sell_point = $purchase_rate *= $coin->getSellPercentage();

					if($purchase_rate >= $sell_point) {
						if( Config::get("mode") === "log" ) {
							Logger::log($coin->getType(), $rate, "sell");
						}
						else if( Config::get("mode") === "notify" ) {
							Notification::sendNotification(
								$coin->getType(),
								"Sell at " . number_format($rate, 8) . " which should be $coin->sell_percentage % under " . number_format($coin->getRunHigh(), 8)
							);
						}
						else if (Config::get("mode") === "buy") {
							$coin->sell($qty, $rate);
						}
						else {
							throw new Exception("Invalid mode type selected");
						}
					}

				}

				// Just Wait
				else {

				}

			}
			sleep(1);

		}

		dd("Done");
	}
	catch(Exception $e) {
		dd($e);
	}

?>
