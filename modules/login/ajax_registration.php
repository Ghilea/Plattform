<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyValidation.php", "/res/class/classMySession.php");

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
$classArray = array("myCheck", "mySession");

foreach ($classArray as $value) {
	${$value} = new $value();
}

/***************************/
/* if user online          */
/***************************/
$myCheck->setOnline(false);

/***************************/
/* post data               */
/***************************/
$postData = array("firstname", "lastname", "email", "yearOfBirth", "gender", "address", "city", "zipCode", "phoneNumber", "password", "repassword");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//header message
	$headerMessage = "Refresh:1; index.php";

    /***************************/
	/* validate data	       */
	/***************************/
	$check = $firstname && $lastname && $email && $gender && $yearOfBirth && $address && $city && $zipCode && $phoneNumber && $password && $repassword;
    
	//check
	if(!$myCheck->checkEmptySpace($check)){
		$errorMessage = "Du måste fylla i alla fält som kräver det.";
	}else{

        $checkInput = array(
            "firstname" => "letters", 
            "lastname" => "letters", 
            "city" => "letters",
            "address" => "letters&numbers",
            "phoneNumber" => "phoneNumber",
            "zipCode" => "zipCode",
            "yearOfBirth" => "civic"
        );
        
        $inputErrors = array(
            "Förnamnet får bara innehålla bokstäver.",
            "Efternamnet får bara innehålla bokstäver.",
            "Staden får bara innehålla bokstäver.",
            "Adressen får bara innehålla bokstäver.",
            "Telefonnummret får bara innehålla siffror.",
            "Postnummret får bara innehålla siffror och behöver vara 5 tecken långt.",
            "Personnummret får bara innehålla siffror och behöver vara 12 tecken långt."
        );
        
        //create inputcheck
        $x = 0; foreach($checkInput as $value => $value2){
            
            if(!$myCheck->checkInput(${$value}, $value2)){
		        $errorMessage = $inputErrors[$x];
	        }
            
        $x++; }
 
		//email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errorMessage = "E-postadressen verkar inte vara giltig skriven."; 
		}
		
		//email already exist
		if($database->has("account_information",["AND" => ["email" => $email]])){
			$errorMessage = 'E-postadressen finns redan.';
		}
	
		//password
		if (strlen ($password) < 6){
			$errorMessage = 'Lösenordet måste minst innehålla 6 tecken.';
		}

		//password must be the same
		if($password != $repassword){
			$errorMessage = 'Lösenorden måste vara likadana.';
		}

	}
	
	/***************************/
	/* no errorMessage	       */
	/***************************/
	if(empty($errorMessage)){

            $securedCryptPassword = password_hash($password, PASSWORD_DEFAULT);
		
            if(!$database->has("account",["AND" => ["id" => "1"]])){
                $privilege = "5";
            }else{
                $privilege = "1";
            }

            try {
                $database->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 
                $database->pdo->beginTransaction();

                //add account_setup
                $database->insert("account_setup",
                ["status" => null, "privilege_id" => $privilege, "suspended" => null, "showImage" => null, "showMail" => null, "mailReceived" => null, "showPhoneNumber" => null]);
                                
                //add account_information
                $database->insert("account_information",
                ["#id" => "LAST_INSERT_ID()", "firstname" => $firstname, "lastname" => $lastname, "yearOfBirth" => $yearOfBirth, "gender" => $gender, "address" => $address, "city" => $city, "zipCode" => $zipCode, "phoneNumber" => $phoneNumber, "email" => $email]);
                 
                //add account_payment
                $database->insert("account_payment",
                ["#id" => "LAST_INSERT_ID()", "payment_id" => null, "paymentDate" => NULL]);

                //add account
                $database->insert("account",
                ["#id" => "LAST_INSERT_ID()", "password" => $securedCryptPassword, "image" => null, "#account_setup_id" => "LAST_INSERT_ID()", "#account_information_id" => "LAST_INSERT_ID()", "#account_payment_id" => "LAST_INSERT_ID()"]);
                    
                $database->pdo->commit();
                
            } catch (Exception $e) {
                $database->pdo->rollBack();
                echo "Felmeddelande: " . $e->getMessage();
            }

            //send location
		    header($headerMessage); ?>

	<?php exit; }else{ ?>

		<div class="col-full overlayError">
            <div class="wrap-col">
                <?php echo "<h4>Felmeddelande</h4>".$errorMessage; ?>
            </div>
		</div>
	<?php } 
}

		echo "<br>ajax_Firstname: ".$firstname." <br>ajax_lastname: ".$lastname."<br>ajax_Email: ".$email." <br>ajax_yearOfBirth: ".$yearOfBirth."<br>ajax_gender: ".$gender." <br>ajax_address: ".$address."<br>ajax_city: ".$city." <br>ajax_zipCode: ".$zipCode."<br>ajax_phoneNumber: ".$phoneNumber." <br>ajax_password: ".$password."<br>ajax_repassword: ".$repassword."";
?>
