<?php require_once($_SERVER["DOCUMENT_ROOT"]."/resources/includes/header.php"); 

$topic = new Forum($database, $functions);
$view = $topic->getForumPart("topic"); ?>

<div class="styleLight">
	<div class="content">
		
		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<a href="<?php echo $topic->headerTitle["link"]; ?>"><?php echo $topic->headerTitle["name"]; ?></a> &gt;

							<?php echo $topic->nav["title"]; ?>
						
						</div>
					</div>

					<?php if(!isset($_SESSION["id"])){ ?>		
					<div class="col-full">
						<div class="wrap-col forumBarSetting">
							<a href="<?php echo $topic->add["link"].$topic->id; ?>">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $topic->add["image"]; ?>" alt=""><?php echo $topic->add["name"]; ?>
							</a>
						</div>
					</div>
					<?php } ?>

				</div>
			</div>
		</header>
         
        <!-- Forum -->
		<div class="col-full">
			<div class="wrap-col">
				
				<?php foreach($view as $output){ ?>
				<div class="col-full showHidden">
				
					<a href="<?php echo $topic->link.$output["thread_id"]?>" title="<?php echo $output["title"]; ?>">

						<div class="col-11-12">
							<div class="wrap-col boxForum borderWhiteLeft">

								<!-- box 1 -->
								<div class="col-11-12">
									<div class="wrap-col">
										<h2 class="overflowText"><?php echo $output["title"]; ?></h2>
									</div>
								</div>

								<!-- box 2 -->
								<div class="col-1-12 removeM removeSM">
									<div class="wrap-col">
										<h4><?php echo $output["postCount"]; ?></h4>
										<p class="txtCenter">Svar</p>
									</div>
								</div>
					
							</div>
						</div>
						
					</a>

					<!-- box 3 -->
					<div class="col-1-12 forumBarSetting forumBoxHidden">
						<div class="wrap-col">

						<?php if($topic->privilege <= $topic->edit["privilege"] ){ ?>
						
						<a href="<?php echo $topic->edit["link"].$output["post_id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">	
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $topic->edit["image"]; ?>" title="<?php echo $topic->edit["name"]; ?>" alt="">
								</div>
							</div>
						</a>

						<?php } ?>

						<?php if($topic->privilege <= $topic->delete["privilege"] ){ ?>

						<a href="<?php echo $topic->delete["link"].$output["post_id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">		
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $topic->delete["image"]; ?>" title="<?php echo $topic->delete["name"]; ?>" alt="">
								</div>
							</div>
						</a>

						<?php } ?>

						</div>
					</div>
						
				</div>
				<?php } ?>
				
			</div>
		</div>

	</div>
</div>

<?php require_once($_SERVER["DOCUMENT_ROOT"]."/resources/includes/footer.php"); ?>