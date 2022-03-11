<?php
/***************************/
/* include				   */
/***************************/
$inc = [
	"/res/header.php", 
	"/res/class/classMyValidation.php", 
	"/res/class/classMyDate.php"
];

foreach ($inc as $value) { 
    require_once(absPath("1"). $value); 
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
$classArray = [
	"myDate", 
	"myCheck"
];

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* check			       */
/***************************/
$myCheck->setOnline(true);

/***************************/
/* databas query           */
/***************************/
$query = $database->select("account",[
	"[><]account_information" => ["account_information_id" => "id"],
	"[><]account_payment" => ["account_payment_id" => "id"],
	"[><]account_setup" => ["account_setup_id" => "id"],
	"[><]payment" => ["account_setup_id" => "id"],
	],[
	"title", 
	"annualFee", 
	"paymentNumber", 
	"paymentDate"
	],["AND" => ["account.id" => $_SESSION["id"]], 
	"ORDER" => ["account.id" => "ASC"]]);
	
//var_dump($database->error());

/***************************/
/* array                   */
/***************************/
$data = [
	"Betalning", 
	"Namn", 
	"Betalningmottagare", 
	"Saldo"
]; ?>

<!-- section 1 -->
<div class="styleLight noBottomPadding">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">
					<h2><?php echo $pageTitle[0]; ?></h2>
					<p class="max"><?php echo $pageDescription[0]; ?></p>
				</div>
			</div>
		</header>

	</div>
</div>

<!-- section 3 -->
<div class="styleLight">
	<div class="content">
				
		<!-- information -->
		<div class="col-full">
			<div class="wrap-col">

                <?php foreach ($data as $output){ ?>
                 
                    <div class="col-3-12 col-3-12m removeSM">
                        <div class="wrap-col">
                            <h4 class="overflowText"><?php echo $output; ?></h4>
                        </div>
                    </div>
                
                <?php } ?>

			</div>
		</div>

		<?php foreach($query as $output){

            /***************************/
            /* if statement            */
            /***************************/
            //payment
            if ($myCheck->safe($output['paymentDate']) != NULL){
                $myDate->setReDate('%#B %Y', $myCheck->safe($output["paymentDate"]));
                $paymentData = $myDate->getReDate();
            }else{
                $paymentData = "Obetald";
            } 
            
            $data2 = array($paymentData, $output['title'], $output['paymentNumber'], $output['annualFee']);
            
            ?>
    
			<!-- section1 -->
			<div class="col-full">
				<div class="wrap-col boxForum borderWhiteLeft">

                    <?php foreach($data2 as $value){?>

                        <div class="col-3-12 col-3-12m col-6-12sm">
                            <div class="wrap-col">
                                <p class="txtCenter overflowText" title="<?php echo $myCheck->safe($value); ?>">
                                    <?php echo $myCheck->safe($value); ?>
                                </p>
                            </div>
                        </div>
					
					<?php } ?>
				
				</div>
			</div>
            <!-- end section 1-->

		<?php } ?>

	</div>
</div>

<?php require_once(absPath("2"). "/res/footer.php"); ?>