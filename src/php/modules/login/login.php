<?php require_once($_SERVER["DOCUMENT_ROOT"]."/resources/includes/header.php");

/***************************/
/* post data               */
/***************************/
$postData = ["email", "password", "loginData"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

/***************************/
/* send form			   */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$loginData = $login->login($email, $password);
 } ?>

<!-- Main -->
<div class="styleOverlay">
	<div class="content">

		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/login-enter-signin-glyph.svg" alt="">
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<h2>Logga in</h2>
						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($loginData["errorAll"])){ ?>
							<div class="errorMessage">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $loginData["errorAll_image"];?>" alt="">
								<p>
									<?php echo $loginData["errorAll"];?>
								</p>
							</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</header>

		<!-- formulär -->
		<form id="loginForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">

			<!-- information -->
			<div class="col-full">
				<div class="wrap-col ">

						<div class="col-full">
							<div class="wrap-col">

								<?php if(isset($loginData["errorEmail"])){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $loginData["errorEmail_image"];?>" alt=""><p><?php echo $loginData["errorEmail"];?></p></div><?php } ?>

								<input <?php if(isset($emailError)){ ?> class="inputError"; <?php } ?> type="text" name="email" placeholder="E-postadress *" <?php if($functions->checkEmptySpace($email)){ ?> value="<?php echo $email; ?>"<?php } ?>>

							</div>
						</div>

						<div class="col-full">
							<div class="wrap-col">

								<?php if(isset($loginData["errorPassword"])){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $loginData["errorPassword_image"];?>" alt=""><p><?php echo $loginData["errorPassword"];?></p></div><?php } ?>

								<input <?php if(isset($passwordError)){ ?> class="inputError"; <?php } ?> type="password" name="password" placeholder="Lösenord *" <?php if($functions->checkEmptySpace($password)){ ?> value="<?php echo $password; ?>"<?php } ?>>

							</div>
						</div>

				</div>
			</div>

			<!-- Button -->
			<div class="col-full">
				<div class="wrap-col">
					<button>Logga in</button>
				</div>
			</div>

		</form>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/resources/includes/footer.php"); ?>