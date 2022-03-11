<?php
/***************************/
/* include				   */
/***************************/
require("/res/connection.php");

/***************************/
/* databas query           */
/***************************/
$query = $database->select("product_reservation",
["product_id", "added"]);

//var_dump($database->error());

foreach($query as $output){

	$id[] = $output["product_id"];
	$added[] = $output["added"];
	
	$resArray = array("resID" => $id, "added" => $added);	
}	
	
echo json_encode($resArray, JSON_PRETTY_PRINT);

?>