<?php

	require __DIR__ . '/vendor/autoload.php';

	try {

		

		//$coins = Coin::getAll();
		$coins = Coin::getTestCoins();

		while(true) {


			foreach($coins as $coin) {
				$rate = $coin->getLiveLast();
				$coin->addRate($rate);

				$rate = number_format($rate, 8);
				$rate = (float)$rate;

				// this will get the percentage difference between now and 5 minutes ago
				$five_minute_diff = $coin->getDifference($rate, 5);
				$five_minute_previous = $coin->getPast(5);

				// this will get the percentage difference between now and 30 minutes ago
				$thirty_minute_diff = $coin->getDifference($rate, 30);
				$thirty_minute_previous = $coin->getPast(30);
				
				// this will get the percentage difference between now and 60 minutes ago
				$sixty_minute_diff = $coin->getDifference($rate, 60);
				$sixty_minute_previous = $coin->getPast(60);

				$purchase_rate = $coin->getPurchaseRate();
				
				if( $rate > $coin->getRunHigh() ) {
					$coin->setRunHigh($rate);
				}

				// Buy Block
				if($purchase_rate <= 0) {

					$balance = Account::getBalance($coin->getType());
					if((double)$balance->Available <= 0) {
						$qty = 0;
						//throw new Exception("Nothing In Your " . $coin->getType() . " Wallet");
					}
					else {
						$qty = (double)$balance->Available / 10;
					}


					if( $five_minute_diff > 2 ) {
						$coin->buy($qty, $rate);
						Notification::sendNotification($coin->getType(), "Buy at " . number_format($rate, 8) . " which should be 2% over " . number_format($five_minute_previous, 8) );
					}
					if( $thirty_minute_diff > 5 ) {
						$coin->buy($qty, $rate);
						Notification::sendNotification($coin->getType(), "Buy at " . number_format($rate, 8) . " which should be 5% over " . number_format($thirty_minute_previous, 8) );
					}
					if( $sixty_minute_diff > 10 ) {
						$coin->buy($qty, $rate);
						Notification::sendNotification($coin->getType(), "Buy at " . number_format($rate, 8) . " which should be 10% over " . number_format($sixty_minute_previous, 8) );
					}
				}


				// Sell Block
				else if($purchase_rate > 0 ) {

					$balance = Account::getBalance($coin->getType());
					if((double)$balance->Available <= 0) {

						// verify that the order was placed properly

						throw new Exception("Nothing In Your Wallet");
					}

					$qty = (double)$balance->Available;

					$diff_percent = getPercentDifference($rate, $coin->getRunHigh());
					if($diff_percent <= -2) {
						$coin->sell($qty, $rate);
						Notification::sendNotification($coin->getType(), "Sell at " . number_format($rate, 8) . " which should be 2% under " . number_format($coin->getRunHigh(), 8) );
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
