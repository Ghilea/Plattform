<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/autoloader_class.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$postData = ["searchValue"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

	$query = $database->select("region_municipality", 
	["[><]region" => [
		"region_id" => "id"
		]
	],
	[
		"region_municipality.title(name)",
		"region.title(mun)"
	], 
	[
			"region_municipality.title[~]" => $searchValue
	]);

	$query2 = $database->select("region_district",
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
	]);

	$res = [];

	foreach($query as $output){
				
		$res[] = $output;
	}

	foreach($query2 as $output){
				
		$res[] = $output;
	}

	foreach($query3 as $output){
				
		$res[] = $output;
	}

	echo json_encode($res,JSON_PRETTY_PRINT);
?>