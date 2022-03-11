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
$myCheck->checkURL("forum_thread", "id", $_GET["id"]);
$myCheck->checkURL("forum_thread", "forum_id", $_GET["forum_id"]);

/***************************/
/* get data                */
/***************************/
$getData = ["id", "forum_id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["title", "text", "image", "locked", "sticked", "chainLink", "error"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_thread",
[
	"[><]forum" => ["forum_thread.forum_id" => "id"],
	"[><]forum_post" => ["forum_thread.id" => "forum_thread_id"],
	"[><]account" => ["account_id" => "id"],
	"[><]account_information" => ["account.account_information_id" => "id"]
],[
	"forum_thread.id",
	"forum_post.forum_thread_id",
	"forum.id(forum_id)",
	"forum_post.title", 
	"forum_post.content",
	"forum_post_chain",
	"forum_post.created",
	"forum_post.locked",
	"forum_post.sticked",
	"forum_thread.forum_post_chain"
],[
	"AND" => [
		"forum_post.id" => $id
	]
]);

$queryChain = $database->select("forum_thread",[
	"[><]forum" => ["forum_thread.forum_id" => "id"],
	"[><]forum_post" => ["forum_thread.id" => "forum_thread_id"]
],[
	"forum_thread.id",
	"forum_post.title",
	"forum_thread.forum_post_chain"
],[
	"AND" =>[
		"forum_thread.forum_id" => $forum_id, 
		"forum_post.creator" => 1,
		"forum_post_chain" => 0
	],
	"ORDER" => ["forum_post.created" => "DESC"]
]);
	
//var_dump($database->error());

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
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
	/* no error			       */
	/***************************/
	if(empty($error)){ 
		
		try {
        	$database->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 
            $database->pdo->beginTransaction();
			
			//update thread
			$database->update("forum_thread",[
				"account_id" => $_SESSION['id'],
				"forum_post_chain" => $chainLink
			],[
				"AND" => [
					"id" => $id
				]
			]);
			
			$latest_tread_ID = $database->id();

			//update post
			$database->update("forum_post",[
				"account_id" => $_SESSION['id'], 
				"title" => $title,
				"content" => $text,
				"locked" => $locked,
				"sticked" => $sticked
			],[
				"AND" => [
					"id" => $id
				]
			]);

			//add picture
			if (!empty($_FILES['image']['name'])){

				$imageName = $uploadImg->image($id, $_FILES["image"]["name"], $_FILES["image"]["tmp_name"]);
			
				$database->update("forum_thread",
				["image" => $imageName],["AND" => ["id" => $id]]);
						
			}

			//send location
			$headerMessage = "Location: /pages/forumView.php?id=".$id."";		
			header($headerMessage);

			$database->pdo->commit();
	
		} catch (Exception $e) {
            $database->pdo->rollBack();
            echo "Felmeddelande: " . $e->getMessage();
		}

	}
} ?>

<!-- form -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $id; ?>&forum_id=<?php echo $forum_id; ?>" enctype="multipart/form-data" method="post">

	<!-- section 1 -->
	<div class="styleLight">
		<div class="content">
		
			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Ändra</h2>
					    <h4>Rättar till dina fel, svåra än så är det inte</h4>
					</div>
				</div>
			</header>

		<?php foreach($query as $output){ ?>

			<!-- box -->
			<div class="col-4-12 col-4-12m">
				<div class="wrap-col">

					<!-- chainlink -->	
					<div class="col-full">
						<div class="wrap-col">
				
							<select name="chainLink" id="chainLink">
								<option value="">Sammankoppla tråd</option>
										
										<?php foreach($queryChain as $outputChain){
										
										if($chainLink == $outputChain["id"] || $outputChain["id"] == $output["forum_post_chain"]) {
											$chainLinkData = 'selected="selected"';
										}else{
											$chainLinkData = "";
										}

										?>
	
										<option value="<?php echo $outputChain["id"]; ?>" <?php echo $chainLinkData; ?>> 
											<?php echo $outputChain["title"]; ?>
										</option>
	
									<?php } ?>

							</select>

						</div>
					</div>

					<!-- image -->	
					<div class="col-full">
						<div class="wrap-col ">
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
					<div class="full">
						<div class="wrap-col">
							<?php if(isset($titleError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $titleError;?></p></div><?php } ?>

							<input <?php if(isset($titleError)){ ?> class="inputError"; <?php } ?> type="text" name="title" placeholder="Rubrik" <?php if($myCheck->checkEmptySpace($title)){ ?> value="<?php echo $title; ?>"<?php }else{ ?> value="<?php echo $myCheck->safe($output["title"]); } ?>">
						</div>
					</div>
					
					<!-- bbcode -->
					<div class="col-full">
						<div class="wrap-col bbCodeMenu">
							<?php echo $myBBCode->bbCodeMenu(); ?>
							
							<?php if(isset($_SESSION["id"]) && ($_SESSION['privilege'] >= "4")){ ?>
						
								<!-- locked -->
								<input type="checkbox" name="locked" id="locked" value="1" <?php if(($locked || $output["locked"]) == "1"){ ?> checked="checked" <?php } ?>>
								
								<label id="lock" title="Lås tråd" for="locked"><img src="/res/images/svg/editor-lock-glyph.svg"></label> 
								
								<!-- sticked -->
								<input type="checkbox" name="sticked" id="sticked" value="1" <?php if(($sticked || $output["sticked"]) == "1"){ ?> checked="checked" <?php } ?>>
								
								<label id="stick" title="Klistra tråd" for="sticked"><img src="/res/images/svg/editor_pin.svg"></label>

							<?php } ?> 
						</div>
					</div>
					
					<!-- Textarea -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($textError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $textError;?></p></div><?php } ?>

							<textarea <?php if(isset($textError)){ ?> class="inputError"; <?php } ?> id="text" name="text" rows="10" cols="30" placeholder="Information *"><?php if($myCheck->checkEmptySpace($text)){ echo $text; }else{ echo $myCheck->safe($output["content"]); } ?></textarea>
						</div>
					</div>

				</div>
			</div>

			<?php } ?>

			<!-- button -->		
			<div class="col-full">
				<div class="wrap-col">
					<button>Ändra</button>
				</div>
			</div>

		</div>
	</div>

</form>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>

<script defer src="/res/js/imageUpload.js"></script>
<script defer src="/res/js/bbCode.js"></script>