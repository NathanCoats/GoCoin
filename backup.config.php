<?php
	return [
		"secret"			=> '',
		"key"				=> '',
		"email"				=> '',
		"email_password"	=> '',
		'to_email'			=> '',
		'to_phone'			=> '',
		'from_email_name'	=> '',
		'disable_ssl'		=> true,
		'debug'				=> false,
		'db_host'			=> '127.0.0.1',
		'db'				=> 'go_coin',
		'db_user'			=> 'root',
		'db_pass'			=> '',

		// it can be log, buy, or notify
		'buy'				=> false,
		'log'				=> true,
		'notify'			=> false,


		"active_coins"	=> [
			"btc-ada" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 1.5,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-dash" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-ark" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 3.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-powr" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-eth" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> 2.0 ]
				]
			],
			"btc-ltc" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-vtc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> 1.5 ]
				]
			],
			"btc-waves" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 1.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-mona" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ],
				]
			],
			"btc-omg" => (object)[
				"high_percentage" => 1.5,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			// "btc-eng" => (object)[
			// 	"high_percentage" => .75,
			// 	"low_percentage" => 1.0,
			// 	'time_limits' => [
			// 		(object)[ "minutes"	=> .2, "percent"	=> .5 ],
			// 		//(object)[ "minutes"	=> 2, "percent"	=> 2.0 ],
			// 		//(object)[ "minutes"	=> 5, "percent"	=> 3.0 ]
			// 	]
			// ],
			"btc-steem" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 1.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			// "btc-nxt" => (object)[
			// 	"high_percentage" => 1.5,
			// 	"low_percentage" => 2.0,
			// 	'time_limits' => [
			// 		(object)[ "minutes"	=> .2, "percent"	=> .5 ],
			// 		//(object)[ "minutes"	=> 2, "percent"	=> 2.0 ],
			// 		//(object)[ "minutes"	=> 5, "percent"	=> 3.0 ]
			// 	]
			// ],
			"btc-neo" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-snt" => (object)[
				"high_percentage" => 1.5,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-emc2" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 3.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ],
					//(object)[ "minutes"	=> 2, "percent"	=> 1.0 ],
					//(object)[ "minutes"	=> 5, "percent"	=> 3.0 ]
				]
			],
			// "btc-fct" => (object)[
			// 	"high_percentage" => .75,
			// 	"low_percentage" => 3.0,
			// 	'time_limits' => [
			// 		(object)[ "minutes"	=> .2, "percent"	=> .5 ],
			// 		//(object)[ "minutes"	=> 2, "percent"	=> 2.0 ],
			// 		//(object)[ "minutes"	=> 5, "percent"	=> 3.0 ]
			// 	]
			// ],
			"btc-cvc" => (object)[
				"high_percentage" => 1.75,
				"low_percentage" => 2.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
			"btc-xlm" => (object)[
				"high_percentage" => .75,
				"low_percentage" => 3.0,
				'time_limits' => [
					(object)[ "minutes"	=> .2, "percent"	=> .5 ]
				]
			],
		],
	];
?>