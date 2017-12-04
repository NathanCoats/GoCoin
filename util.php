<?php

	define("DS", DIRECTORY_SEPARATOR);

	function dd($data = null) {
		die(var_dump($data));
	}

	function getBasePath() {
		// this works because util is in the base directory
		return getcwd();
	}

	function getMarkets() {
		$request = new Request("public/getmarkets");
		$results = $request->getRequest([]);
		if($results->success != true) {
			throw new Exception($result->message);
		}
		return $results->result;
	}

?>