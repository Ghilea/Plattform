<?php
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myCheck = new Check($_SESSION["privilege"]);

/***************************/
/* check data		       */
/***************************/
$myCheck->onlineCheck();
//kolla om användaren har rätt id ska fixas
$myCheck->checkURL("forum", "id", $_GET["id"]);

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* delete query		       */
/***************************/
$query = ["forum" => "id"];
foreach($query as $value => $value2){$database->delete($value,["AND" => [$value2 => $id]]);}

/* send location */
$headerMessage = "Location: /pages/forum.php";
header($headerMessage); 

/***************************/
/* include				   */
/***************************/
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>