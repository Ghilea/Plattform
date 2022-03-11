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
/* post data               */
/***************************/
$postData = array("firstname", "lastname", "email", "yearOfBirth", "gender", "address", "city", "zipCode", "phoneNumber", "password", "repassword");

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

?>

<!-- Main -->
<div class="styleOverlay">
	<div class="content">

	<!-- header -->
	<header>
		<div class="col-full">
			<div class="wrap-col">

                <div class="col-full">
					<div class="wrap-col">
				        <h2>Bli medlem</h2>
                    </div>
				</div>

			</div>
		</div>
	</header>
			
        <!-- form -->
        <form id="registrationForm" action="#" enctype="multipart/form-data" method="post">

            <!-- information -->
            <div class="col-full">
                <div class="wrap-col">

                    <!-- name -->
                    <div class="col-full">
                        <div class="wrap-col">
                            <h3>Namn</h3>

                            <input title="Förnamn" type="text" name="firstname" placeholder="Förnamn *" <?php if($myCheck->checkEmptySpace($firstname)){ ?> value="<?php echo $firstname; ?>"<?php } ?>>
                        </div>
                    </div>

                    <div class="col-full">
                        <div class="wrap-col">
                             <input title="Efternamn" type="text" name="lastname" placeholder="Efternamn *" <?php if($myCheck->checkEmptySpace($lastname)){ ?> value="<?php echo $lastname; ?>"<?php } ?>>
                        </div>
                    </div>

                    <!-- email -->
                    <div class="col-full">
                        <div class="wrap-col">
                            <input title="E-postadress" type="text" name="email" placeholder="E-postadress *" <?php if($myCheck->checkEmptySpace($email)){ ?> value="<?php echo $email; ?>"<?php } ?>>
                        </div>
                    </div>

                    <!-- password & re enter password -->
                    <div class="col-full">
                        <div class="wrap-col">
                            <h3>Lösenord</h3>
                            
                            <input title="Lösenord" type="password" name="password" placeholder="Lösenord *" <?php if($myCheck->checkEmptySpace($password)){ ?> value="<?php echo $password; ?>"<?php } ?>>
                        </div>
                    </div>
        
                    <div class="col-full">
                        <div class="wrap-col">
                            <input title="Upprepa lösenord" type="password" name="repassword" placeholder="Upprepa lösenord *" <?php if($myCheck->checkEmptySpace($repassword)){ ?> value="<?php echo $repassword; ?>"<?php } ?>>
                        </div>
                    </div>

                </div>
            </div>
                
            <!-- button -->		
            <div class="col-full">
                <div class="wrap-col">
                    <button>Bli medlem</button>
                </div>
            </div>
                
        </form>

    </div>
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.php"); ?>