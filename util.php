<?php

	define("DS", DIRECTORY_SEPARATOR);

	function dd($data = null) {
		die(var_dump($data));
	}

	function getBasePath() {
		// this works because util is in the base directory
		return getcwd();
	}

	function jsPath($filename) {
		return "resources" . DS . "js" . DS . $filename;
	}

	function getMarkets() {
		$request = new Request("public/getmarkets");
		$results = $request->getRequest([]);
		if($results->success != true) {
			throw new Exception($result->message);
		}
		return $results->result;
	}

	function getPercentDifference($new_rate, $old_rate) {
		if($old_rate <= 0 || $new_rate <= 0) return 0;
		return (($new_rate - $old_rate) / $old_rate) * 100;
	}

?>