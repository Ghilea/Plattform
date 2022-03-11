<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/autoloader_class.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$postData = ["place"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

	$query = $database->count("events",  
	["location" => $place]);
	
	echo json_encode($query,JSON_PRETTY_PRINT);
?>