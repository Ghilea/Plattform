<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$query = $database->select("modules_content", 
	["content", "link"], 
	["class[~]" => "sideNavButton"]);

echo json_encode($query,JSON_PRETTY_PRINT);
?>