<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$post = new Forum($database, $functions);
$view = $post->getForumPart("post"); ?>

<div class="styleLight">
	<div class="content">

		<!-- header -->
		<header>
			<div class="col-full">
				<div class="wrap-col">

					<div class="col-full">
						<div class="wrap-col">
							<a href="<?php echo $post->headerTitle["link"]; ?>"><?php echo $post->headerTitle["name"]; ?></a> &gt;
							<a href="<?php echo $post->headerTitle2["link"].$post->nav["forum_id"]; ?>"><?php echo $post->nav["title"]; ?></a> &gt;
							<?php echo $post->nav["threadTitle"]; ?>
						</div>
					</div>

					<!-- settings -->
					<!-- fixa så det inte visas när tråden är låst -->
					<?php if(!isset($_SESSION["id"])){ ?>		
					<div class="col-full">
						<div class="wrap-col forumBarSetting">
							<a href="<?php echo $post->add["link"].$post->id; ?>">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $post->add["image"]; ?>" alt=""><?php echo $post->add["name"]; ?>
							</a>
						</div>
					</div>
					<?php } ?>

				</div>
			</div>
		</header>
		
		<!-- forum -->
		<div class="col-full">
			<div class="wrap-col">

				<?php foreach($view as $output){ ?>
				<div class="col-full showHidden">

                    <div class="col-11-12">
						<div class="wrap-col boxForum borderWhiteLeft">

							<!-- box1 -->
							<div class="col-1-12 removeM removeSM">
								<div class="wrap-col">

									<figure class="circleImg">
										<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo /*$output["image"];*/ $post->edit["image"]; ?>" alt="">
									</figure>

									<p class="txtCenter">
										<?php echo $output["firstname"]." ".$output["lastname"]; ?>
									</p>
								</div>
							</div>

							<!-- box2 -->
							<div class="col-10-12">
								<div class="wrap-col">

									<p class="boxForumText">
                                        <?php echo $output["content"]; ?>
									</p>
								</div>
							</div>

							<!-- box date -->
							<div class="boxForumDate">
								<?php echo $functions->rewriteDate($output["created"]); ?>
							</div>

						</div>
					</div>

					<!-- box 3 -->
					<div class="col-1-12 forumBarSetting forumBoxHidden">
						<div class="wrap-col">

						<!-- if(($_SESSION["id"] == $post->account_id[$x]) || ($_SESSION['privilege'] >= "4")){ -->
						<?php if($post->privilege <= $post->edit["privilege"] ){ ?>
						
						<!-- <a href="/pages/editPost.php?id=<?php //echo $post->post_id[$x]; ?>&forum_id=<?php //echo $post->forum_id[$x]; ?>"> -->
						<a href="<?php echo $post->edit["link"].$output["post_id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">	
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $post->edit["image"]; ?>" title="<?php echo $post->edit["name"]; ?>" alt="">
								</div>
							</div>
						</a>

						<?php } ?>

						<?php if($post->privilege <= $post->delete["privilege"] ){ ?>

						<a href="<?php echo $post->delete["link"].$output["post_id"]; ?>">
							<div class="col-full">
								<div class="wrap-col boxForum">		
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $post->delete["image"]; ?>" title="<?php echo $post->delete["name"]; ?>" alt="">
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