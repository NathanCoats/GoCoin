<?php
	return [
		"secret"			=> '',
		"key"				=> '',
		"email"				=> '',
		"email_password"	=> '',
		'to_email'			=> '',
		'to_phone'			=> '4444444444@vtext.com',
		'from_email_name'	=> '',
		'disable_ssl'		=> true,
		'debug'				=> false,
		'db'				=> 'go_coin',
		'db_host'			=> '127.0.0.1',
		'db_user'			=> 'root',
		'db_pass'			=> '',
		'percentages' => [
			//minute to percent
			(object)[
				"minutes"	=> 1,
				"percent"	=> 1.0
			],
			(object)[
				"minutes"	=> 30,
				"percent"	=> 5.0
			],
			(object)[
				"minutes"	=> 60,
				"percent"	=> 10.0
			],
		],

		// it can be log, buy, or notify
		'log'				=> false,
		'notify'			=> false,
		'buy'				=> false,


		"active_coins"	=> [
			"btc-ada" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-dash" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-ark" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-powr" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-eth" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-ltc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-vtc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-waves" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-mona" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-omg" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-eng" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-sc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-nxt" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-xrp" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-neo" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-snt" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-emc2" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-fct" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-xvg" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-cvc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
			"btc-xlm" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
			],
		],
	];
?>
