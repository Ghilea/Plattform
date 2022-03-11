<?php

class Account {

    public function __construct($database = null, Functions $functions = null){
        $this->db = $database;
        $this->fk = $functions;
    }  

    public function accountMenu(){

        $query = $this->db->select("modules_content",
        [ 
            "name",
            "link",
            "image"
        ],[
            "AND" =>["type" => "accountMenu", "active" => 1],
            "ORDER" => ["sortOrder" => "ASC"]]);

        return $query;

    }

    public function paymentTableTitle(){

        $query = $this->db->select("modules_content",
        [ 
            "name"
        ],[
            "AND" =>["type" => "paymentTableTitle", "active" => 1],
            "ORDER" => ["sortOrder" => "ASC"]]);

        return $query;

    }

    public function getAccount($id){
        
        $path = "/uploads/account/";

        $queryInformation = $this->database->select("account",[
            "[><]account_information" => ["account_information_id" => "id"],
            "[><]account_settings" => ["account_settings_id" => "id"],
        ],[ 
            "account_information.firstname",
            "account_information.lastname",
            "account_information.address",
            "account_information.city",
            "account_information.zipCode",
            "account_information.phoneNumber",
            "account_information.email",
            "account.image",
            "account_settings.profile_image(showImage)",
            "account_settings.PhoneNumber(showPhoneNumber)",
            "account_settings.email(showEmail)",
        ],[
            "AND" =>["account.id" => $id]]);
        
        foreach($queryInformation as $output){
            $this->information["firstname"] = $output["firstname"];
            $this->information["lastname"] = $output["lastname"];
            $this->information["address"] = $output["address"];
            $this->information["city"] = $output["city"];
            $this->information["zipCode"] = $output["zipCode"];
            $this->information["phoneNumber"] = $output["phoneNumber"];
            $this->information["email"] = $output["email"];
            $this->information["showImage"] = $output["showImage"];
            $this->information["showPhoneNumber"] = $output["showPhoneNumber"];
            $this->information["showEmail"] = $output["showEmail"];
            $this->information["image"] = $path.$output["image"]; 
        }

        $queryPayment = $this->database->select("account",[
            "[><]account_payment" => ["id" => "account_id"],
            "[><]system_payment" => ["account_payment.system_payment_id" => "id"],
        ],[
            "account_payment.status",
            "account_payment.date",
            "system_payment.fee", 
            "system_payment.paymentNumber"
        ],["AND" => ["account.id" => $id], 
            "ORDER" => ["account.id" => "ASC"]]);

        foreach($queryPayment as $output){
            $this->paymentStatus[] = $output["status"];
            $this->paymentDate[] = $output["date"];
            $this->paymentFee[] = $output["fee"].":-";
            $this->paymentNumber[] = "#".$output["paymentNumber"];
        }

        if ($this->number == null && $id != null) {
            $count = $this->database->count("account_payment", [
	        "account_id" => $id
            ]);

            $this->number = $count;
        }

    }

    protected function dump(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $city == "adad"){

	/***************************/
	/* validate data	       */
	/***************************/
    /*$check = [
		["name" => "text", "regex" => "bbCode", "error" => "textError", "message" => "Du kan använda bokstäver, nummer och många av de vanligaste symbolerna."]
	];
    
	foreach($check as $output) {

		//empty space
		if(!$myCheck->checkEmptySpace(${$output["name"]})){

			$error = 1;
			${$output["error"]} = $output["message"];

		//characters
		}else if(!$myCheck->checkInput(${$output["name"]}, $output["regex"])){

			$error = 1;
		    ${$output["error"]} = $output["message"];
		}
	}*/

	//error message
	$checkError = "<h3>Du måste fylla i alla fält som kräver det.</h3>";
	
	//no error message
	$noErrorMessage = "<h3>Informationen ändrades utan några problem.</h3>";
	
	//header message
	$headerMessage = "location: /pages/account.php";

	/***************************/
	/* validate data	       */
	/***************************/
	$check = $email && $address && $city && $zipCode && $phoneNumber;
    
	if(!$functions->checkEmptySpace($check)){
		$errorMessage = $checkError;
	}else{
	
        $checkInput = [
            "city" => "letters",
            "address" => "letters&numbers",
            "phoneNumber" => "phoneNumber",
            "zipCode" => "zipCode"
		];
        
        $inputErrors = [
            "Staden får bara innehålla bokstäver.",
            "Adressen får bara innehålla bokstäver.",
            "Telefonnummret får bara innehålla siffror.",
            "Postnummret får bara innehålla siffror."
		];
        
        //variable
        $x = 0;
        
        //create inputcheck
        foreach($checkInput as $value => $value2){
            
            if(!$myCheck->checkInput(${$value}, $value2)){
		        $errorMessage = $inputErrors[$x];
	        }
            
            $x++;
        }
        
		//email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errorMessage = "E-postadressen verkar inte vara giltig skriven."; 
		}
			
		//email already exist
		if(!$database->has("account_information",["AND" => ["email" => $email]])){
			$errorMessage = 'E-postadressen finns redan.';
		}
	
		/*if ($myCheck->checkEmptySpace($password)){
			
            //password
			if (strlen ($password) < 6)
			{
				$errorMessage = 'Lösenordet måste minst innehålla 6 tecken.';
			}
			
            //password must be the same
			if($password != $repassword)
			{
				$errorMessage = 'Lösenorden måste vara likadana.';
			}
			
		}*/
        
        //upload image
		if(!empty($_FILES['image']['name'])){

			//check image size
			if ($_FILES["image"]["size"] > 500000){
				$errorMessage = 'Bilden är för stor.';
			}

			//check image format
			if($_FILES["image"]["type"] != "image/jpg" && $_FILES["image"]["type"] != "image/png" && $_FILES["image"]["type"] != "image/jpeg"){
				$errorMessage =  "Du kan bara ladda JPG, JPEG eller PNG bilder.";
			}
		}

	}
	
	/***************************/
	/* no errorMessage	       */
	/***************************/
	if(empty($errorMessage)){ 
		
        //add account_setup		
		/*$database->update("account_settings",
		["showImage" => $showImage, "showMail" => $showMail, "showPhoneNumber" => $showPhoneNumber],["AND" => ["id" => $_SESSION["id"]]]);
		
        //add account_information	
		$database->update("account_information",
		["address" => $address, "city" => $city, "zipCode" => $zipCode, "phoneNumber" => $phoneNumber, "email" => $email],["AND" => ["id" => $_SESSION["id"]]]);
		*/
		//add image
		if (!empty($_FILES['image']['name'])){

			$image = $uploadImg->image($_SESSION["id"], $_FILES["image"]["name"], $_FILES["image"]["tmp_name"], "../uploads/account/");

			$database->update("account",
			["image" => $image],["AND" => ["id" => $_SESSION["id"]]]);

		}
				
		/*if ($myCheck->checkEmptySpace($password)){
			$securedCryptPassword = password_hash($password, PASSWORD_DEFAULT);
		
			$database->update("account",
			["password" => $securedCryptPassword],["AND" => ["id" => $_SESSION["id"]]]);
		}*/
		
		//send location
		header($headerMessage); ?>

		<div class="col-full noError">
			<div class="wrap-col">
				<?php echo $noErrorMessage; ?>
			</div>
		</div>
		
	<?php }else{ ?>

		<div class="col-full error">
			<div class="wrap-col">
				<h3><?php echo $errorMessage; ?></h3>
			</div>
		</div>

	<?php }
}
    }
}

?>