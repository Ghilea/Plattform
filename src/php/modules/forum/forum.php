<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$forum = new Forum($database, $functions);
$view = $forum->getForumPart("forum"); ?>

<div class="styleLight">
	<div class="content">	

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">
					
					<div class="col-full">
						<div class="wrap-col">
							<?php echo $forum->headerTitle["name"]; ?>
						</div>
					</div>

				<?php if($forum->privilege >= $forum->add["privilege"]){ ?>		
					<div class="col-full">
						<div class="wrap-col forumBarSetting">
							<a id="addForum" href="javascript:void(0);" class="sideNavButton">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $forum->add["image"]; ?>" alt=""><?php echo $forum->add["name"]; ?>
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
			
				<?php foreach($view as $output) { ?>
				<div class="col-full showHidden">
	
					<a href="<?php echo $forum->link.$output["id"]?>" title="<?php echo $output["title"]; ?>">

						<div class="col-11-12">
							<div class="wrap-col boxForum border<?php echo $output["color"] ?>Left">

								<!-- box 1 -->
								<div class="col-11-12">
									<div class="wrap-col">
										<h2 class="overflowText"><?php echo $output["title"]; ?></h2>
										<p class="overflowText"><?php echo $output["content"]; ?></p>
									</div>
								</div>

								<!-- box 2 -->
								<div class="col-1-12 removeM removeSM">
									<div class="wrap-col">
										<h4><?php echo $output["threadCount"]; ?></h4>
										<p class="txtCenter">Trådar</p>
									</div>
								</div>

							</div>
						</div>

					</a>
				
					<!-- box 3 -->
					<div class="col-1-12 forumBarSetting forumBoxHidden">
						<div class="wrap-col">

						<?php if($forum->privilege >= $forum->edit["privilege"] ){ ?>
						
						<a class="editForum sideNavButton" href="javascript:void(0) <?php //echo $forum->edit["link"].$output["id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">	
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $forum->edit["image"]; ?>" title="<?php echo $forum->edit["name"]; ?>" alt="">
								</div>
							</div>
						</a>

						<?php } ?>

						<?php if($forum->privilege >= $forum->edit["privilege"] ){ ?>

						<a href="<?php echo $forum->delete["link"].$output["id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">		
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $forum->delete["image"]; ?>" title="<?php echo $forum->delete["name"]; ?>" alt="">
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

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>