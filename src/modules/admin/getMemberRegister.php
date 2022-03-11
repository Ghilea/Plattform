<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyValidation.php", "/res/class/classMyDate.php");

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
$classArray = array("myDate", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* post data               */
/***************************/
$postData = array("search");

foreach($postData as $value){
    if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;} 
}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("account",
[
"[><]account_information" => ["account_information_id" => "id"],
"[><]account_payment" => ["account_payment_id" => "id"],
"[><]account_setup" => ["account_setup_id" => "id"]
],[
"firstname", 
"lastname", 
"yearOfBirth", 
"email", 
"paymentDate"
],[
"AND" => ["OR" => ["firstname[~]" => $search, "lastname[~]" => $search, "email[~]" => $search, "yearOfBirth[~]" => $search, "paymentDate[~]" => $search]]
],[
"privilege" => ["1", "3"], 
"ORDER" => ["account.id ASC"], "LIMIT" => "10"]);
	
//var_dump($database->error());

foreach($query as $output){

    /***************************/
    /* set class               */
    /***************************/
    $myDate->setAgeNum($myCheck->safe($output['yearOfBirth']));
    $myDate->setAgeCalc($myCheck->safe($output["yearOfBirth"]));
    $myDate->setReDate('%#B %Y', $myCheck->safe($output["paymentDate"]));

    /***************************/
    /* if statement            */
    /***************************/
    //payment
    if ($myCheck->safe($output['paymentDate']) != NULL){
        $paymentData = $myDate->getReDate();
    }else{
        $paymentData = "Obetald";
    } ?>

    <!-- section1 -->
    <div class="col-full">
        <div class="wrap-col boxForum borderWhiteLeft">

            <!-- year of birth -->
            <div class="col-3-12 col-3-12m col-6-12sm">
                <div class="wrap-col">
                    <p class="txtCenter overflowText" title="<?php echo $myDate->getAgeNum(); ?> ( <?php echo $myDate->getAgeCalc(); ?> år )">
                        <?php echo $myDate->getAgeNum(); ?> ( <?php echo $myDate->getAgeCalc(); ?> år )
                    </p>
                </div>
            </div>
            
            <!-- name -->
            <div class="col-3-12 col-3-12m col-6-12sm">
                <div class="wrap-col">
                    <p class="txtCenter overflowText" title="<?php echo $myCheck->safe($output['firstname']); ?> <?php echo $myCheck->safe($output['lastname']); ?>">
                        <?php echo $myCheck->safe($output['firstname']); ?> <?php echo $myCheck->safe($output['lastname']); ?>
                    </p>
                </div>
            </div>
            
            <!-- email -->
            <div class="col-3-12 col-3-12m col-6-12sm">
                <div class="wrap-col">
                    <p class="txtCenter overflowText" title="<?php echo $myCheck->safe($output['email']); ?>">
                        <?php echo $myCheck->safe($output['email']); ?>
                    </p>
                </div>
            </div>
                
            <!-- payment -->
            <div class="col-3-12 col-3-12m col-6-12sm">
                <div class="wrap-col">
                    <p class="txtCenter overflowText" title="<?php echo $paymentData; ?>">
                        <?php echo $paymentData; ?>
                    </p>
                </div>
            </div>
        
        </div>
    </div>

<?php } ?>