<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/header.php", "/res/class/classMyPage.php", "/res/class/classMyValidation.php");

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
$classArray = array("myPage", "myCheck");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* information			   */
/***************************/	
$myPage->setInformation("partners");
$pageTitle = $myPage->getTitle();
$pageDescription = $myPage->getDescription();

/***************************/
/* databas query           */
/***************************/
$query = $database->select("forum_topic",
[
"[><]forum" => ["forum_topic.forum_id" => "id"],
"[><]forum_thread" => ["forum_thread_id" => "id"],
"[><]forum_thread_setup" => ["forum_thread.forum_thread_setup_id" => "id"],
],[
"forum_topic.id", 
"forum_thread.title", 
"forum_thread.description",
"forum_thread.added",
],
["AND" =>
[
"forum_topic.forum_id" => "4",
"forum_thread_setup.created" => "1"
], 
"ORDER" => ["forum_thread.added" => "DESC"], 
"LIMIT" => "15"]);

//var_dump($database->error());
	
?>
<!-- section 1 -->
<div class="styleLight">
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
		
		<!-- information -->
		<div class="col-full">
			<div class="wrap-col">

			<?php foreach($query as $output){ ?>
			
				<div class="col-full">
					<div class="wrap-col boxForum">
						<h2><?php echo $output["title"]; ?></h2>
						<p><?php echo nl2br($output["description"]); ?></p>
					</div>
				</div>

			<?php } ?>
			
			</div>
		</div>
	
	</div>
</div>

<?php require_once(absPath("2"). "/res/footer.php"); ?>