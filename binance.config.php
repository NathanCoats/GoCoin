<?php
	return [
		"secret"			=> '',
		"key"				=> '',
		"email"				=> '',
		"email_password"	=> '',
		'to_email'			=> '',
		'to_phone'			=> '',
		'from_email_name'	=> 'Jack Johnson',
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
			"adabtc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"dashbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"arkbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"powrbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],

				]
			],
			"ethbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> 2.0 ],
				]
			],
			"ltcbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"wavesbtc" => (object)[
				"high_percentage" => 1.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"omgbtc" => (object)[
				"high_percentage" => 1.5,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"neobtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"sntbtc" => (object)[
				"high_percentage" => 1.5,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
			"xlmbtc" => (object)[
				"high_percentage" => 2.0,
				"low_percentage" => 7.5,
				'time_limits' => [
					(object)[ "minutes"	=> .5, "percent"	=> .5 ],
				]
			],
		],
	];
?>