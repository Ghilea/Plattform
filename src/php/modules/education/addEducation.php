<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myBBCode = new BBCode();
$myCheck = new Check($_SESSION["privilege"]);
$uploadImg = new Upload();

/***************************/
/* check data		       */
/***************************/
$myCheck->onlineCheck();

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["chainLink", "locked", "sticked", "title", "text", "image", "time", "error"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* time				   */
/***************************/
date_default_timezone_set("Europe/Stockholm");
$time = date("Y-m-d H:i:s");

/***************************/
/* databas query           */
/***************************/		
$queryChain = $database->select("education",[
	"id",
	"title"
],["ORDER" => ["title" => "ASC"]]);

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$difficulty = "lätt";

	/***************************/
	/* validate data	       */
	/***************************/
	$check = [
		["name" => "title", "regex" => "title", "error" => "titleError", "message" => "Du kan använda bokstäver, nummer och de vanligaste symbolerna."],
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

		//upload image
		if(!empty($_FILES['image']['name'])){

			//check image size
			if ($_FILES["image"]["size"] > 1000000){
				$error = 1;
				$imageError = "Bilden du försöker ladda upp är för stor.";
			}

			//check image format
			if($_FILES["image"]["type"] != "image/jpg" && $_FILES["image"]["type"] != "image/png" && $_FILES["image"]["type"] != "image/jpeg"){
				$error = 1;
				$imageError =  "Bildformaten som kan användas är JPG, JPEG eller PNG.";
			}

		}
	}

	/***************************/
	/* no error	     		   */
	/***************************/
	if(empty($error)){ 
	
		try {
        	$database->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 
            $database->pdo->beginTransaction();

			if ($chainLink == null){
				//add education
				$database->insert("education",[
					"account_id" => $_SESSION['id'],
					"title" => $title,			
					"content" => $text,
					"difficulty" => $difficulty,
					"sticked" => $sticked
				]);

				$latest_ID = $database->id();

				//add picture
				if (!empty($_FILES['image']['name'])) {

					$image = $uploadImg->image($latest_ID, $_FILES["image"]["name"], $_FILES["image"]["tmp_name"], "../uploads/language/");
				
					$database->update("education",
					["image" => $image],["AND" => ["id" => $latest_ID]]);
				}

			}else{
				//add task
				$database->insert("education_task",[
					"education_id" => $chainLink, 
					"title" => $title,
					"content" => $text,
					"sticked" => $sticked,
				]);
			}

			//send location
			$headerMessage = "Location: /pages/account";	
			header($headerMessage);
		
			$database->pdo->commit();
	
		} catch (Exception $e) {
            $database->pdo->rollBack();
            echo "Felmeddelande: " . $e->getMessage();
        } 

 	}
} ?>

<!-- form -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post">
	
	<!-- section 1 -->	
	<div class="styleLight">
		<div class="content">
		
			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Lägg till utbildning</h2>
					</div>
				</div>
			</header>

			<!-- box -->
			<div class="col-4-12 col-4-12m">
				<div class="wrap-col">
				
					<!-- chainlink -->	
					<div class="col-full">
						<div class="wrap-col">

							<select name="chainLink" id="chainLink">
								<option value="">Uppgift till utbildning</option>

									<?php foreach($queryChain as $output){ ?>
									
										<?php if ($chainLink == $output["id"]){
											$chainLinkData = 'selected="selected"';
										}else{
											$chainLinkData = "";
										} ?>
										
										<option value="<?php echo $output["id"]; ?>" <?php echo $chainLinkData; ?>> 
											<?php echo $output["title"]; ?>
										</option>
										
									<?php } ?>

							</select>

						</div>
					</div>

					<!-- image -->	
					<div class="col-full">
						<div class="wrap-col">
							<figure class="uploadImageBox">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="" alt="" id="upImage">
								<figcaption><p>Lägg till bild</p></figcaption>
							</figure>
							<input type="file" name="image" id="imageInput">
						</div>
					</div>

				</div>
			</div>

			<!-- box -->
			<div class="col-8-12 col-8-12m">
				<div class="wrap-col">
					
					<!-- title -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($titleError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $titleError;?></p></div><?php } ?>

							<input <?php if(isset($titleError)){ ?> class="inputError"; <?php } ?> type="text" name="title" placeholder="Rubrik *" <?php if($myCheck->checkEmptySpace($title)){ ?> value="<?php echo $title; ?>"<?php } ?>>
						</div>
					</div>
					
					<!-- bbcode -->
					<div class="col-full">
						<div class="wrap-col bbCodeMenu">
							<?php echo $myBBCode->bbCodeMenu(); ?>
							
							<?php if(isset($_SESSION["id"]) && ($_SESSION['privilege'] >= "4")){ ?>
						
								<!-- locked -->
								<input type="checkbox" name="locked" id="locked" value="1" <?php if($locked == "1"){ ?> checked="checked" <?php } ?>>
								
								<label id="lock" title="Lås tråd" for="locked"><img src="/images/svg/editor-lock-glyph.svg"></label> 
								
								<!-- sticked -->
								<input type="checkbox" name="sticked" id="sticked" value="1" <?php if($sticked == "1"){ ?> checked="checked" <?php } ?>>
								
								<label id="stick" title="Klistra tråd" for="sticked"><img src="/images/svg/editor_pin.svg"></label>

							<?php } ?> 
						</div>
					</div>
					
					<!-- text -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($textError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $textError;?></p></div><?php } ?>

							<textarea <?php if(isset($textError)){ ?> class="inputError"; <?php } ?> id="text" name="text" rows="10" cols="30" placeholder="Information *"><?php if($myCheck->checkEmptySpace($text)){ echo $text; } ?></textarea>
						</div>
					</div>

				</div>
			</div>
						
			<!-- button -->		
			<div class="col-full">
				<div class="wrap-col">
					<button>Lägg till</button>
				</div>
			</div>

		</div>
	</div>
	
</form>	

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>

<script defer src="/javaScript/bbCode.js"></script>