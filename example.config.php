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
			(object)[
				"name" => "btc-ada",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-dash",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-ark",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-powr",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-eth",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-ltc",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-vtc",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-waves",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-mona",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-omg",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-eng",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-sc",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-nxt",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-xrp",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-neo",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-snt",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-emc2",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-fct",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-xvg",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-cvc",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
			(object)[
				"name" => "btc-xlm",
				"high_percentage" => 0.01,
				"low_percentage" => 0.01,
			],
		],
	];
?>
