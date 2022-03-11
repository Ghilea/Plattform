<?php
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myCheck = new Check();

/***************************/
/* check data		       */
/***************************/
//$myCheck->onlineCheck();
//$myCheck->checkURL("forum_post", "forum_thread_id", $_GET["id"]);

/***************************/
/* get data                */
/***************************/
$getData = ["id", "forum_id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* delete query		       */
/***************************/
$deleteQuery = ["forum_thread" => "id", "forum_post" => "forum_thread_id"];

foreach($deleteQuery as $value => $value2){$database->delete($value,["AND" => [$value2 => $id]]);}

/* send location */
$headerMessage = "Location: /pages/forumTopic.php?id=".$forum_id."";
header($headerMessage); 

/***************************/
/* include				   */
/***************************/
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>