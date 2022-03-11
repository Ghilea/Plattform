<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/autoloader_class.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$postData = ["place"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

	$query = $database->select("events", 
	["type"], 
	["location" => $place]);

	$res = [];

	$res = array_count_values(array_column($query, "type"));

	foreach($res as $key => $value){
		$res[$key] = round(($value / array_sum($res) * 100), 2);
	}

	echo json_encode($res, JSON_NUMERIC_CHECK);
?>