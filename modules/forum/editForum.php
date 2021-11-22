<?php 
$myBBCode = new BBCode();

//$myCheck->onlineCheck();
//$myCheck->getAccess(4);
//$myCheck->checkURL("forum", "id", $_GET["id"]);

/***************************/
/* get data                */
/***************************/
$getData = ["id"];

foreach($getData as $value){if(isset($_GET[$value])){${$value} = intval($_GET[$value]);}else{${$value} = null;}}

/***************************/
/* post data               */
/***************************/
$postData = ["title", "text", "privilege", "color", "error"];

foreach($postData as $value){if(isset($_POST[$value])){${$value} = $_POST[$value];}else{${$value} = null;}}

/***************************/
/* databas query           */
/***************************/
/*$query = $database->select("forum", [
	"[><]forum_color" => ["forum.forum_color_id" => "id"],
	"[><]account_privilege" => ["forum.account_privilege_id" => "id"]
],[
	"forum.id",
	"forum.title",
	"forum.content",
	"forum.account_privilege_id",
	"forum.forum_color_id",
	"account_privilege.title(privilegeTitle)",
	"forum_color.title(colorTitle)"
],[
	"AND" => ["forum.id" => $id]
]);

$queryColor = $database->select("forum_color", ["id", "title", "color"]);

$queryPrivilege = $database->select("account_privilege", ["id", "title"]);

//var_dump($database->error());*/

/***************************/
/* send form	           */
/***************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
    /***************************/
	/* validate data	       */
	/***************************/
	$check = [
		["name" => "privilege", "regex" => "title", "error" => "privilegeError", "message" => "Du behöver välja rättigheter."],
		["name" => "color", "regex" => "title", "error" => "colorError", "message" => "Du behöver välja färg."],
		["name" => "title", "regex" => "title", "error" => "titleError", "message" => "Du kan använda bokstäver, nummer och de vanligaste symbolerna."],
		["name" => "text", "regex" => "bbCode", "error" => "textError", "message" => "Du kan använda bokstäver, nummer och många av de vanligaste symbolerna."]
	];

	foreach($check as $output) {

		//empty space
		if(!$functions->checkEmptySpace(${$output["name"]})){

			$error = 1;
			${$output["error"]} = $output["message"];

		//characters
		}else if(!$functions->checkInput(${$output["name"]}, $output["regex"])){

			$error = 1;
		    ${$output["error"]} = $output["message"];
		}
	}
	
	/***************************/
	/* no error			       */
	/***************************/
	if(empty($error)){ 
        
        //update
		$database->update("forum",
		["title" => $title, "content" => $text, "account_privilege_id" => $privilege, "forum_color_id" => $color],["AND" => ["id" => $id]]);

		//send location
        $headerMessage = "Location: /pages/forumTopic.php?id=".$id."";
		header($headerMessage); 
	}
} ?>

<!-- formulär -->
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post">

	<!-- section 1 -->
	<div class="styleLight">
		<div class="content">
		
			<!-- header -->
			<header>
				<div class="col-full">
					<div class="wrap-col">
						<h2>Ändra forumdel</h2>
					</div>
				</div>
			</header>

			<?php foreach($query as $output){ ?>
			
			<!-- box -->
			<div class="col-4-12 col-4-12m">
				<div class="wrap-col">
					
					<!-- privledge -->		
					<div class="col-full">
						<div class="wrap-col">

							<?php if(isset($privilegeError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $privilegeError;?></p></div><?php } ?>

							<select <?php if(isset($privilegeError)){ ?> class="inputError"; <?php } ?> name="privilege" id="privilege">
								<option value="">Välj privilegier *</option>

								<?php foreach($queryPrivilege as $outputPrivilege){ ?>
								
									<?php if(isset($privilege)){
											
											if ($privilege == $outputPrivilege["id"]){
												$privilegeData = 'selected="selected"';
											}else{
												$privilegeData = "";
											}
											
										}else{
											
											if ($outputPrivilege["title"] == $output["privilegeTitle"]){
												$privilegeData = 'selected="selected"';
											}else{
												$privilegeData = "";
											}
											
										} ?>
										
										<option value="<?php echo $outputPrivilege["id"]; ?>" <?php echo $privilegeData; ?>> 
											<?php echo $outputPrivilege["title"]; ?>
										</option>
                                    
                                <?php } ?>

							</select>
						</div>
					</div>
					
					<!-- color -->	
					<div class="col-full">
						<div class="wrap-col">

							<?php if(isset($colorError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $colorError;?></p></div><?php } ?>

							<select <?php if(isset($colorError)){ ?> class="inputError"; <?php } ?> name="color" id="color">
								<option value="">Välj färg *</option>
                          
									<?php foreach($queryColor as $outputColor){ ?>
										
										<?php if(isset($color)){
											
											if ($color === $outputColor["id"]){
												$colorData = 'selected="selected"';
											}else{
												$colorData = "";
											}

										}else{
											
											if ($outputColor["title"] == $output["colorTitle"]){
												$colorData = 'selected="selected"';
											}else{
												$colorData = "";
											}
											
										} ?>
										
										<option value="<?php echo $outputColor["id"]; ?>" <?php echo $colorData; ?>> 
											<?php echo $outputColor["title"]; ?>
										</option>
										
									<?php } ?>

							</select>
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
							<?php if(isset($titleError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $titleError;?></p></div><?php } ?>

							<input <?php if(isset($titleError)){ ?> class="inputError"; <?php } ?> type="text" name="title" placeholder="Rubrik" <?php if($functions->checkEmptySpace($title)){ ?> value="<?php echo $title; ?>"<?php }else{ ?> value="<?php echo $functions->safe($output["title"]); } ?>">
						</div>
					</div>
					
					<!-- bbcode -->
					<div class="col-full">
						<div class="wrap-col bbCodeMenu">
							<?php echo $myBBCode->bbCodeMenu(); ?>
						</div>
					</div>

					<!-- text -->
					<div class="col-full">
						<div class="wrap-col">
							<?php if(isset($textError)){ ?><div class="errorMessage"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/res/images/svg/circle-minus-plus-glyph.svg" alt=""><p><?php echo $textError;?></p></div><?php } ?>

							<textarea <?php if(isset($textError)){ ?> class="inputError"; <?php } ?> id="text" name="text" rows="10" cols="30" placeholder="Information *"><?php if($functions->checkEmptySpace($text)){ echo $text; }else{ echo $functions->safe($output["content"]); } ?></textarea>
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

<script defer src="/modules/default/js/bbCode.js"></script>