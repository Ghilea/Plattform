<?php
/***************************/
/* include				   */
/***************************/
require_once($_SERVER['DOCUMENT_ROOT']."/includes/header.php"); 

/***************************/
/* new class               */
/***************************/
$myBBCode = new BBCode();

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
					<h2>Vanligt förekommande frågor</h2>
					<h4>Mer information kommer snart</h4>
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
						<p><?php echo useBBCode($output["description"]); ?></p>
					</div>
				</div>

			<?php } ?>
			
			</div>
		</div>
	
	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/includes/footer.php"); ?>