<?php

	require __DIR__ . '/vendor/autoload.php';

	try {

		//$coins = Coin::getAll();
		$coins = Coin::getTestCoins();

		$log = Config::get("log");
		$notify = Config::get("notify");
		$buy = Config::get("buy");


		echo "Coins Retrieved and Process Starting:\n";
		while(true) {

			$time_start = microtime(true);
			foreach($coins as $coin) {
				$coin_start = microtime(true);
				$rate = $coin->getLiveLast();
				$coin->addRate($rate);

				// $rate = number_format($rate, 8);
				// $rate = (float)$rate;
				$time_limits 	= $coin->getTimeLimits();

				foreach ($time_limits as &$limit) {
					$limit->previous  = $coin->getPast($limit->minutes);
					$limit->difference = $coin->getDifference($rate, $limit->minutes);
				}

				$purchase_rate = $coin->getPurchaseRate();
				// Buy Block
				if($purchase_rate <= 0) {

					foreach ($time_limits as $limit) {
						if($purchase_rate > 0) continue;
						if( $limit->difference >= $limit->percent ) {

							if( $log ) {
								Logger::log($coin->getType(), $rate, 1, "buy");

								// this is done in the buy method, but in order to keep the logs correct this needs to be done
								$coin->markBought($rate);
							}
							if( $notify ){
								Notification::sendEmail(
									$coin->getType(),
									"Buy at " . number_format($rate, 8) . " which should be $limit->percent% over " . number_format($limit->previous, 8)
								);

								// this is done in the buy method, but in order to keep the notifications correct this needs to be done
								$coin->markBought($rate);
							}
							if( $buy ) {
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

						$balance = Account::getBalance( $coin->getType() );
						if((double)$balance->Available <= 0) {
							// verify that the order was placed properly
							throw new Exception("Nothing In Your Wallet");
						}

						$qty = (double)$balance->Available;
					}
					catch(Exception $e) {
						$qty = 1;
					}

					$high_point =  $purchase_rate  + ($purchase_rate * ( $coin->getHighPercentage() / 100) );
					$low_point =  $purchase_rate  - ($purchase_rate * ( $coin->getLowPercentage() / 100) );
					$percent_gain = $coin->getHighPercentage();
					$percent_lost =  -1  * $coin->getLowPercentage();

					if($rate >= $high_point || $rate <= $low_point) {
						if($rate >= $high_point) $percent = $percent_gain;
						else $percent = $percent_lost;

						if( $log ) {
							Logger::log($coin->getType(), $rate, 1, "sell");

							// this is done in the sell method, but in order to keep the logs correct this needs to be done
							$coin->markSold();
						}
						if( $notify ) {
							Notification::sendEmail(
								$coin->getType(),
								"Sell at " . number_format($rate, 8) . " which should be $percent% diff " . number_format($coin->getPurchaseRate(), 8)
							);

							// this is done in the sell method, but in order to keep the notifications correct this needs to be done
							$coin->markSold();
						}
						if( $buy ) {
							$coin->sell($qty, $rate);
						}
					}


				}

				// Just Wait
				else {

				}
				$coin_end = microtime(true);
				$coin_run_time = $coin_end - $coin_start;
				//echo $coin->getType() . ": took $coin_run_time\n";

			}
			$time_end = microtime(true);
			$run_time = $time_end - $time_start;
			//echo "$run_time\n";

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
