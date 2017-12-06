<?php

	require __DIR__ . '/vendor/autoload.php';

	try {
		//$coins = Coin::getAll();
		$coins = Coin::getTestCoins();

		while(true) {


			foreach($coins as $coin) {
				//$curTime = microtime(true);

				$rate = $coin->getLiveLast();
				$coin->addRate($rate);

				$rate = number_format($rate, 8);
				$rate = (float)$rate;

				// this will get the percentage difference between now and 5 minutes ago
				// $one_minute_diff = $coin->getDifference($rate, 1);
				$five_minute_diff = $coin->getDifference($rate, 5);
				$thirty_minute_diff = $coin->getDifference($rate, 30);
				$sixty_minute_diff = $coin->getDifference($rate, 60);

				// if($one_minute_diff != 0) {
				// 	echo $coin->getType() . " : " . $one_minute_diff . "\n";
				// }

				// if($five_minute_diff != 0) {
				// 	echo $coin->getType() . " : " . $five_minute_diff . "\n";
				// }

				// if($thirty_minute_diff != 0) {
				// 	echo $coin->getType() . " : " . $thirty_minute_diff . "\n";
				// }

				// if($sixty_minute_diff != 0) {
				// 	echo $coin->getType() . " : " . $sixty_minute_diff . "\n";
				// }


				$purchase_rate = $coin->getPurchaseRate();

				// this will have to be fixed soon.
				$qty = 1;

					$coin->buy($qty, $rate);

				// Buy Block
				if( ($five_minute_diff > 2 || $thirty_minute_diff > 5 || $sixty_minute_diff > 10) && $purchase_rate == 0) {
					$coin->buy($qty, $rate);
				}

				// Sell Block
				else if( $five_minute_diff < 2 && $purchase_rate > 0) {
					$coin->sell($qty, $rate);

				}

				// Just Wait
				else {

				}

			}
			sleep(1);
			//$timeConsumed = round(microtime(true) - $curTime,3)*1000;

		}

		dd("Done");
	}
	catch(Exception $e) {
		dd($e);
	}

?>
