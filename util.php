<?php

	function dd($data) {
		die(var_dump($data));
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