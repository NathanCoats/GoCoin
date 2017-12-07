<?php
	return [
		"secret"			=> '',
		"key"				=> '',
		"email"				=> '',
		"email_password"	=> '',
		'to_email'			=> '',
		'to_phone'			=> '4354354354@vtext.com',
		'from_email_name'	=> 'Jack Johnson',
		'disable_ssl'		=> true,
		'debug'				=> false,
		'db'				=> 'go_coin',
		'db_host'			=> '127.0.0.1',
		'db_user'			=> '',
		'db_pass'			=> '',
		'percentages' => [
			//minute to percent
			(object)[
				"minutes"	=> 5,
				"percent"	=> 2.0
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
		'mode'				=> 'log',


		"active_coins"	=> [
			(object)[ 
				"name" => "btc-ada",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-dash",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-ark",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-powr",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-eth",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-ltc",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-vtc",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-waves",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-mona",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-omg",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-eng",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-sc",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-nxt",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-xrp",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-neo",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-snt",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-emc2",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-fct",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-xvg",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-cvc",
				"sell_percentage" => 2.0,
			],
			(object)[ 
				"name" => "btc-xlm",
				"sell_percentage" => 2.0,
			],
		],
	];
?>
