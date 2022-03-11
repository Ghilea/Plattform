<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/autoloader_class.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$postData = ["place"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

//$place = "Gävle";

	$query = $database->select("events", 
	["type"], 
	["location" => $place]);

	/*$query2 = $database->select("region_district",
	["[><]region_municipality" => [
		"region_municipality_id" => "id"
		]
	], 
	[
		"name", 
		"title(dis)"
	],
	[
		"name[~]" => $searchValue
	]);

	$query3 = $database->select("region",
	[
		"title"
	],
	[
		"title[~]" => $searchValue
	]);*/

	$res = [];
	$out = [];

	//print_r($query);

	//print_r($query);
	$res = array_count_values(array_column($query, "type"));

	/*foreach ($query as $value){

		$res = $value;		

	}*/

	/*foreach($query2 as $output){
				
		$res[] = $output;
	}

	foreach($query3 as $output){
				
		$res[] = $output;
	}*/

	echo json_encode($res,JSON_PRETTY_PRINT);
?>