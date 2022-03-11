<?php 
/***************************/
/* include				   */
/***************************/
$inc = ["/res/header.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php", "/res/class/classMyBBCode.php"];

foreach ($inc as $value) {require_once(absPath("1"). $value); }

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){return realpath(dirname(__dir__, $value));}

/***************************/
/* new class               */
/***************************/
$classArray = ["myDate", "myBBCode", "myCheck"];

foreach ($classArray as $value) {${$value} = new $value();}
    
/***************************/
/* post data               */
/***************************/
$postData = array("added");

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* databas query           */
/***************************/


//var_dump($database->error());

/***************************/
/* send form		       */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	/***************************/
	/* validate data	       */
	/***************************/
	$check = [
		["name" => "added", "regex" => "title", "error" => "titleError", "message" => "Du kan använda bokstäver, nummer och de vanligaste symbolerna."]
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

		//check added for right format
		$dateCheck = DateTime::createFromFormat("Y-m-d", $added);

		if ($dateCheck == false){
			$errorMessage = 'Du måste ange ett giltigt datum.';
		}
        
        if ($added < date("Y-m-d")){
			$errorMessage = 'Du kan inte boka in gamla datum.';
		}

		//check if reservationdate already exist on bike choosen
		if($database->has("product_reservation",["AND" => ["product_id" => $id, "added" => $added]])){
			$errorMessage = 'Datumet är redan inbokad för denna cykel.';
		}
		
		//check so user only can do 3 reservation per bike
		$count = $database->count("product_reservation",
		["AND" => ["account_id" => $_SESSION['id'], "product_id" => $id, "added[>=]" =>  date("Y-m-d")]]);

		if($count >= 3){
			$errorMessage = 'Du kan bara boka in 3 olika datum per cykel.';
		}

	}

	/***************************/
	/* no error			       */
	/***************************/
	if(empty($error)){ 

        //add reservation
		$database->insert("product_reservation",
		["account_id" => $_SESSION['id'], "product_id" => $id, "added" => $added]);
				
		//send location
		$headerMessage = "Refresh:1; /pages/product/productView.php?id=".$id."";
		header($headerMessage); 
	}
} ?>

<!-- form -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post">

	<!-- section4 -->
	<div class="styleLight">
		<div class="content">

			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Schema för gruppträningar</h2>
					</div>
				</div>
			</header>
			
			<!-- information -->
			<div class="col-full">
				<div class="wrap-col">
                    
					<!-- Date -->
                    <div class="col-full">
					    <div class="wrap-col">

                            <h3 id="title">
                                <?php $myDate->setReDate("%B", date('Y-m-d', strtotime('+0 month', strtotime(date("Y-m-01"))))); ?>
                                <?php echo $myDate->getReDate(); ?>
                            </h3>
             
                            <div id="body"></div>
                    
						</div>
					</div>
					 
					<?php if(isset($_SESSION["id"])){ ?>
                    <!-- input date -->
                    <div class="col-6-12">
                        <div class="wrap-col">
                            
                            <h3>Boka</h3>
                            <p>hh</p>
                                    
                            <div class="col-full">
                                <div class="wrap-col">
                                
                                    <input readonly type="text" name="added" id="added" placeholder="ÅÅÅÅ-MM-DD" <?php if($myCheck->checkEmptySpace($added)){ ?> value="<?php echo $added; ?>"<?php } ?>>

                                </div>
                            </div>
                            
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
                                    
                        </div>
					</div>

					<!-- button -->		
					<div class="col-full">
						<div class="wrap-col">
							<button>Boka</button>
						</div>
					</div>
					
					<?php } ?>

				</div>
			</div>

		</div>
	</div>	

</form>

<?php require_once(absPath("1"). "/res/footer.php"); ?>

<script defer src="/res/js/calendar.js"></script>