<?php

	require __DIR__ . '/vendor/autoload.php';

	try {

		//$coins = Coin::getAll();
		$coins = Coin::getTestCoins();
		echo "Coins Retrieved and Process Starting:\n";
		if(!is_array(Config::get("percentages"))) throw new Exception("config.percentages must be defined as an array");
		while(true) {

			$time_start = microtime(true);
			foreach($coins as $coin) {
				$coin_start = microtime(true);
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
					

					foreach ($percentages as $percent) {
						if( $percent->difference >= $percent->percent ) {

							if( Config::get("log") ) {
								Logger::log($coin->getType(), $rate, 1, "buy");

								// this is done in the buy method, but in order to keep the logs correct this needs to be done
								$coin->markBought($rate);
							}
							if( Config::get("notify") ){
								Notification::sendNotification(
									$coin->getType(),
									"Buy at " . number_format($rate, 8) . " which should be $percent->percent over " . number_format($coin->getRunHigh(), 8)
								);

								// this is done in the buy method, but in order to keep the notifications correct this needs to be done
								$coin->markBought($rate);
							}
							if( Config::get("buy") ) {
								try {		
									$balance = Account::getBalance();
									if((double)$balance->Available <= 0) {
										$qty = 1;
										//throw new Exception("Nothing In Your BTC Wallet");
									}
									else {
										$qty = (double)$balance->Available / 2;
									}
								}
								catch(Exception $e) {
									$qty = 1;
								}
								$coin->buy($qty, $rate);
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
						$qty = 1;
					}

					$sell_point = $purchase_rate *= $coin->getSellPercentage();

					if($purchase_rate >= $sell_point) {
						if( Config::get("log") ) {
							Logger::log($coin->getType(), $rate, 1, "sell");

							// this is done in the sell method, but in order to keep the logs correct this needs to be done
							$coin->markSold();
						}
						if( Config::get("notify") ) {
							Notification::sendNotification(
								$coin->getType(),
								"Sell at " . number_format($rate, 8) . " which should be $coin->sell_percentage % under " . number_format($coin->getRunHigh(), 8)
							);

							// this is done in the sell method, but in order to keep the notifications correct this needs to be done
							$coin->markSold();
						}
						if( Config::get("buy") ) {
							$coin->sell($qty, $rate);
						}
					}

				}

				// Just Wait
				else {

				}
				$coin_end = microtime(true);
				$coin_run_time = $coin_end - $coin_start;
				echo $coin->getType() . ": took $coin_run_time\n";

			}
			$time_end = microtime(true);
			$run_time = $time_end - $time_start;
			echo "$run_time\n";

			if($run_time < 1) {
				$diff = 1 - $run_time;
				//usleep(100000 * $diff);
			} 

		}

		dd("Done");
	}
	catch(Exception $e) {
		dd($e);
	}

?>
