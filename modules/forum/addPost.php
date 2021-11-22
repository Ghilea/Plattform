<?php 
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myBBCode = new BBCode();
$myCheck = new Check();

/***************************/
/* check data		       */
/***************************/
$myCheck->onlineCheck();
$myCheck->checkURL("forum_thread", "id", $_GET["id"]);
$myCheck->checkLocked();

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["title", "text", "time", "error"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* time				   */
/***************************/
date_default_timezone_set("Europe/Stockholm");
$time = date("Y-m-d H:i:s");

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    /***************************/
	/* validate data	       */
	/***************************/
    $check = [
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
	}
	
	/***************************/
	/* no error			       */
	/***************************/
	if(empty($error)){ 

        //add to topic
        $database->insert("forum_post",[
			"title" => $title, 
			"content" => $text,
			"creator" => null,
			"forum_thread_id" => $id, 
			"account_id" => $_SESSION["id"], 
			"locked" => null,
			"sticked" => null,
			"reported" => null,
			"created" => $time
		]);
                
		//send location
		$headerMessage = "Location: /pages/forumView.php?id=".$id."";
		header($headerMessage);
	}
} ?>

<!-- form -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post">

	<!-- section 1 -->
	<div class="styleLight">
		<div class="content">
		
			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Lägg till inlägg</h2>
					    <h4>Skriv ett inlägg och var med och diskutera</h4>
					</div>
				</div>
			</header>
			
			<!-- box -->
			<div class="col-full">
				<div class="wrap-col">
					
					<!-- title -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($titleError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $titleError;?></p></div><?php } ?>

							<input <?php if(isset($titleError)){ ?> class="inputError"; <?php } ?> type="text" name="title" placeholder="Rubrik" <?php if($myCheck->checkEmptySpace($title)){ ?> value="<?php echo $title; ?>"<?php } ?>>
						</div>
					</div>

					<!-- bbcode -->
					<div class="col-full">
						<div class="wrap-col bbCodeMenu">
							<?php echo $myBBCode->bbCodeMenu(); ?>
						</div>
					</div>
							
					<!-- Textarea -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($textError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $textError;?></p></div><?php } ?>

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

<script defer src="/res/js/bbCode.js"></script>