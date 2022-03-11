<?php
/***************************/
/* include				   */
/***************************/
require_once(dirname(__DIR__, 2)."/res/connection.php");
require_once(dirname(__DIR__, 2)."/res/class/class_check.php");
require_once(dirname(__DIR__, 2)."/res/class/class_session.php");

/***************************/
/* new class			   */
/***************************/
$mySession = new Session();
$myCheck = new Check();
	
/***************************/
/* post data			   */
/***************************/
$postData = ["email", "password"];

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* databas query		   */
/***************************/
$query = $database->select("account",[
	"[><]account_information" => ["account_information_id" => "id"],
	"[>]system_gender" => ["system_gender_id" => "id"],
	"[><]account_settings" => ["account_settings_id" => "id"],
	"[>]system_privilege" => [".system_privilege_id" => "id"]
],[
	"account.id", "email", "password", "suspended", "account_privilege_id"
]);

//var_dump($database->error());

/***************************/
/* send form			   */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	/***************************/
	/* validate data		   */
	/***************************/
	$check = $email && $password;

	//check
	if(!$myCheck->checkEmptySpace($check)){
		$errorMessage = "Du måste fylla i alla fält som kräver det.";
	}else{

		foreach($query as $output){

			//Check if account is baned
			if ($output["suspended"] == '1'){
				$errorMessage = 'Användarkontot är avstängd.';	
			}

			//Check so user got the right email and password
			if ($myCheck->safe($output["email"] == $email) 
			&& (password_verify($password, $output['password']))){

			}else{
				$errorMessage = 'E-postadressen eller lösenordet är fel.';
			}
		}
	}

	/***************************/
	/* no errorMessage	       */
	/***************************/
	if(empty($errorMessage)){

		foreach($query as $output){

		//add sessions
		$mySession->setSessionData("email", $email);
		$mySession->setSessionData("id", $output["id"]);
		$mySession->setSessionData("privilege", $output["account_privilege_id"]);

		//add login time
		$database->update("account_setup",
		["status" => "1"],["id" => $output["id"]]);
		
		}
		//send location
		//header("Location: /index.php");
 	}
 } ?>