<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/header.php", "/res/class/classMyValidation.php");

foreach ($inc as $value) {
    require_once(absPath("2"). $value);
}

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){
	return realpath(dirname(__dir__, $value));
}

/***************************/
/* new class               */
/***************************/
$classArray = array("myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* check data		       */
/***************************/
$myCheck->setOnline(true);
$myCheck->setGetCheck("product_reservation", "id", $_GET["id"]);
$myCheck->setAccess("4", false);

/***************************/
/* get data                */
/***************************/
$getData = array("id");

foreach($getData as $value){
	if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}
}

/***************************/
/* delete query		       */
/***************************/
$query = array("product_reservation" => "id");

foreach($query as $value => $value2){
    $database->delete($value,["AND" => [$value2 => $id]]);

	//var_dump($database->error());
}

/***************************/
/* send location	       */
/***************************/
$headerMessage = "Location: /pages/account/myReservation.php";

header($headerMessage); 

/***************************/
/* include				   */
/***************************/
require_once(absPath("2"). "/res/footer.php"); ?>