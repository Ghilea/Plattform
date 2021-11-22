<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/autoloader_class.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$postData = ["searchValue", "query"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

	$mun = $database->has("region_municipality", [
		"AND" => ["title" => $searchValue]
	]);

	$dis = $database->has("region_district", [
		"AND" => ["name" => $searchValue]
	]);

	$reg = $database->has("region", [
		"AND" => ["title" => $searchValue]
	]);

	if($mun){
		$query = $database->get("region_municipality",
			["title", "latitude", "longitude","polygon","zoom"],
			["AND" => ["title" => $searchValue]]
		);
	}
	
	if($dis){
		$query = $database->get("region_district",
			["name", "latitude", "longitude", "polygon","zoom"],
			["AND" => ["name" => $searchValue]]
		);
	}

	if($reg){
		$query = $database->get("region",
			["title", "latitude", "longitude", "polygon", "zoom"],
			["AND" => ["title" => $searchValue]]
		);
	}

	echo json_encode($query,JSON_PRETTY_PRINT);
?>