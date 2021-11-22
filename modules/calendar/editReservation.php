<?php 
/***************************/
/* include				   */
/***************************/
$inc = array("/res/header.php", "/res/class/classMyPage.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php");

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
$classArray = array("myPage", "myDate", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}
                            
/***************************/
/* check data		       */
/***************************/
$myCheck->setOnline(true);
$myCheck->setGetCheck("product_reservation", "id", $_GET["id"]);
$myCheck->setGetCheck("product", "forum_topic_id", $_GET["product_id"]);
$myCheck->setAccess("4", false);

/***************************/
/* information 			   */
/***************************/
$myPage->setInformation("editMyReservation");
$pageTitle = $myPage->getTitle();
$pageDescription = $myPage->getDescription();

/***************************/
/* get data                */
/***************************/
$getData = array("id", "product_id");

foreach($getData as $value){ 
    if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;} 
}

/***************************/
/* post data               */
/***************************/
$postData = array("added");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("product_reservation",[
"[><]account" => ["product_reservation.account_id" => "id"],
"[><]account_information" => ["account.account_information_id" => "id"]
],[
"product_reservation.id", 
"product_reservation.added"],
["AND" => ["product_reservation.id" => $product_id, "product_reservation.account_id" => $_SESSION["id"]]]);

//var_dump($database->error());

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	//error message
	$checkError = "<h3>Du måste fylla i ett datum i det fält som kräver det.</h3>";
	
	//no error message
	$noErrorMessage = "<h3>Informationen ändrades utan problem. Du skickas nu vidare.</h3>";
    
    //header message
    $headerMessage = "Refresh:1; /pages/account/myReservation.php";
	
	/***************************/
	/* validate data	       */
	/***************************/
	$check = $added;
    
	if(!$myCheck->checkEmptySpace($check)){
		$errorMessage = $checkError;
	}else{
		
		//Tittar så att datumet följer rätt format
		$dateCheck = DateTime::createFromFormat('Y-m-d', $added);
		
		if ($dateCheck == false){
			$errorMessage = 'Du måste ange ett giltigt datum.';
		}
        
        if ($added < date("Y-m-d")){
			$errorMessage = 'Du kan inte boka in gamla datum.';
		}

		//Tittar om bokningsdatumet redan finns på vald cykel
		if($database->has("product_reservation",["AND" => ["product_id" => $product_id, "added" => $added]])){
			$errorMessage = 'Datumet är redan inbokad för denna cykel.';
		}

	}
	
	/***************************/
	/* no errorMessage	       */
	/***************************/
	if(empty($errorMessage)){ 
        
        //add product_reservation
		$database->update("product_reservation",
		["added" => $added],["AND" => ["id" => $id]]);
        
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
} ?>

<!-- formulär -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $id; ?>&product_id=<?php echo $product_id; ?>" enctype="multipart/form-data" method="post">

<!-- section 1 -->
<div class="styleLight">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full" id="productView">
				<div class="wrap-col">
                    <h2><?php echo $pageTitle[0]; ?></h2>
                    <p class="max"><?php echo $pageDescription[0]; ?></p>
				</div>
			</div>
		</header>
			
		<!-- information -->
		<div class="col-full">
			<div class="wrap-col">
				
				<!-- Date -->
				<div class="col-6-12">
					<div class="wrap-col">

						<h3 id="title">
                            <?php $myDate->setReDate("%B", date('Y-m-d', strtotime('+0 month', strtotime(date("Y-m-01"))))); ?>
                            <?php echo $myDate->getReDate(); ?>
                        </h3>
							
						<div id="body"></div>
                            
					</div>
				</div>
							
				<div class="col-6-12">
					<div class="wrap-col">
						<h3><?php echo $pageTitle[1]; ?></h3>
					    <p<?php echo $pageDescription[1]; ?></p>
						
						<!-- date input -->	
						<div class="col-full">
                            <div class="wrap-col">
                                
                                <input type="text" name="added" id="added" placeholder="ÅÅÅÅ-MM-DD" <?php if($myCheck->checkEmptySpace($added)){ ?> value="<?php echo $added; ?>"<?php } ?>>

                            </div>
                        </div>
                        
						<!-- select month -->
                        <div class="col-full">
							<div class="wrap-col">

								<select name="month" id="month">
                                        
									<?php $monthArray = array("0", "1", "2");
                                            
                                	foreach ($monthArray as $value) { ?>
                                        
                                    	<option value="<?php echo $value; ?>">
                                                    
                                        	<?php $myDate->setReDate("%B", date('Y-m-d', strtotime('+'.$value.' month', strtotime(date("Y-m-01"))))); ?>
                                                    
                                        	<?php echo $myDate->getReDate(); ?>
                                                    
                                    	</option>

									<?php } ?>
                                       
								</select>

                        	</div>
						</div>
					  
					  	<!-- button -->		
						<div class="col-full">
							<div class="wrap-col">
								<button>Ändra bokning</button>
							</div>
						</div>
                            
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

</form>

<?php require_once(absPath("2"). "/res/footer.php"); ?>

<script defer src="/res/js/calendar.js"></script>