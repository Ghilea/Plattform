<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

$functions = new Functions($database);
$login = new Login($database, $functions);
$acc = new Account($database);

$postData = ["email", "image", "address", "city", "zipCode", "phoneNumber", "password", "repassword", "showImage", "showMail", "showPhoneNumber"];

foreach($postData as $value){
	if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}
}

if(isset($_GET['logout'])) {
	$login->logout($_SESSION["id"]);
} ?>

<!-- Main -->
<div class="styleOverlay">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/resources/images/svg/editor-setting-gear-glyph.svg" alt="">
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<h2>Inställningar</h2>
						</div>
					</div>

				</div>
			</div>
		</header>

		<!-- information -->
		<div class="col-4-12">
			<div class="wrap-col">

				<div class="col-full">
					<div class="wrap-col">
						<h3>Konto</h3>
						<ul>
							<?php foreach ($acc->accountMenu() as $output){ ?>
							<a href="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>">
								<li>
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"];?>">

									<p><?php echo $output["name"]; ?></p>

								</li>
							</a>
							<?php } ?>
						</ul>

					</div>
				</div>

			</div>
		</div>

		<!-- right side -->
		<div class="col-8-12">
			<div class="wrap-col ">
				
		<!-- 					-->
		<!-- payment			-->
		<!-- 					-->
		<div class="col-full">
			<div class="wrap-col">

				<?php foreach ($acc->paymentTableTitle() as $output){ ?>

					<div class="col-3-12 col-3-12m removeSM txtCenter">
						<div class="wrap-col">
							<p class="overflowText"><?php echo $output["name"]; ?></p>
						</div>
					</div>

				<?php } ?>

				<!-- information -->
				<?php for($x = 0; $x < $account->number; $x++){ ?>

					<div class="col-full">
						<div class="wrap-col boxForum borderWhiteLeft">

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentNumber[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentDate[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentStatus[$x]; ?></p>
								</div>
							</div>

							<div class="col-3-12 col-3-12m">
								<div class="wrap-col">
									<p class="overflowText txtCenter"><?php echo $account->paymentFee[$x]; ?></p>
								</div>
							</div>

						</div>
					</div>

				<?php } ?>

			</div>
		</div>

				<!-- view -->
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">

				<div class="col-full">
					<div class="wrap-col">

								<!-- profile picture -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Profilbild</p>

										<figure class="accountPicture">
											<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $account->information["image"]; ?>" alt="">
												
											<figcaption>
												<input type="file" name="image" id="imageInput">
											</figcaption>
										</figure>

									</div>
								</div>

								<!-- address -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Adress</p>

										<input title="Adress" type="text" name="address" placeholder="Adress" <?php if($myCheck->checkEmptySpace($address)){ ?> value="<?php echo $address; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["address"]); ?>"<?php } ?>>

									</div>
								</div>

								<div class="col-8-12 col-4-12m">
									<div class="wrap-col">
	
										<input title="Stad" type="text" name="city" placeholder="Stad" <?php if($myCheck->checkEmptySpace($city)){ ?> value="<?php echo $city; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["city"]); ?>"<?php } ?>>

									</div>
								</div>

								<div class="col-4-12 col-4-12m">
									<div class="wrap-col">
													
										<input title="Postnummer" type="text" name="zipCode" placeholder="Postnummer" <?php if($myCheck->checkEmptySpace($zipCode)){ ?> value="<?php echo $zipCode; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["zipCode"]); ?>"<?php } ?>>

									</div>
								</div>

								<!-- phonenumber -->
								<div class="col-full">
									<div class="wrap-col">
										<p>Telefonnummer</p>

										<input title="Telefonnummer" type="text" name="phoneNumber" placeholder="Telefonnummer" <?php if($myCheck->checkEmptySpace($phoneNumber)){ ?> value="<?php echo $phoneNumber; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["phoneNumber"]); ?>"<?php } ?>>

									</div>
								</div>

								<!-- email -->
								<div class="col-full">
									<div class="wrap-col">
										<p>E-postadress</p>

										<input title="E-postadress" type="text" name="email" placeholder="E-postadress" <?php if($myCheck->checkEmptySpace($email)){ ?> value="<?php echo $email; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($account->information["email"]); ?>"<?php } ?>>

									</div>
								</div>

							</div>
						</div>

						<div class="col full">
							<div class="wrap-col">

								<div class="col-full">
									<div class="wrap-col">
										<p>Foruminställningar</p>

										<!-- show image -->
										<input type="checkbox" name="showImage" id="showImage" value="1" <?php if(($showImage == "1") || ($account->information["showImage"] == "1")){ ?> checked="checked" <?php } ?>>			
													
										<label id="imageShow" title="Visa bild" for="showImage"></label>Visa bild<br>

										<!-- show mail -->
										<input type="checkbox" name="showMail" id="showMail" value="1" <?php if(($showMail == "1") || ($account->information["showEmail"] == "1")){ ?> checked="checked" <?php } ?>>
													
										<label id="mailShow" title="Visa e-postadress" for="showMail"></label>Visa e-postadress<br>

										<!-- show phone number-->
										<input type="checkbox" name="showPhoneNumber" id="showPhoneNumber" value="1" <?php if(($showPhoneNumber == "1") || ($account->information["showPhoneNumber"] == "1")){ ?> checked="checked" <?php } ?>>
													
										<label id="phoneShow" title="Visa telefonnummer" for="showPhoneNumber"></label>Visa telefonnummer<br>

									</div>
								</div>

							</div>
						</div>

						<div class="col full">
							<div class="wrap-col">

								<div class="col-full">
									<div class="wrap-col">
										<p>Lösenord</p>
											
										<input title="Lösenord" type="password" name="password" placeholder="Nuvarande lösenord" <?php if($myCheck->checkEmptySpace($password)){ ?> value="<?php echo $password; ?>"<?php } ?>>
									</div>
								</div>

								<div class="col-full">
									<div class="wrap-col">
												
										<input title="Upprepa lösenord" type="password" name="repassword" placeholder="Upprepa lösenord" <?php if($myCheck->checkEmptySpace($repassword)){ ?> value="<?php echo $repassword; ?>"<?php } ?>>
									</div>
								</div>

							</div>
						</div>

					<!-- button -->		
					<div class="col-full">
						<div class="wrap-col">
							<button>Uppdatera</button>
						</div>
					</div>

				</form>

	</div>
</div>