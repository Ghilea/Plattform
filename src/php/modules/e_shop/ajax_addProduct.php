<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);

$id = $_POST["id"];

$query = $database->insert("product_order", 
	[
		"account_id" => 1, 
		"product_id" => $id,
		"order_id" => 12,
		"price" => 33,
		"quantity" => 1,
		"date" => date("Y-m-d")]);

//echo json_encode($query,JSON_PRETTY_PRINT);
?>