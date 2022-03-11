<?php $education = new Education($database, $functions); ?>

<div class="styleSquare">
	<div class="col-full">
		<div class="flex-container">

			<?php foreach($education->getEducation() as $output){ ?>

				<div class="<?php echo $output["rowClass"].' '.$output["hide"]. ' '.$output["boxColor"]; ?>">

					<a class="link" href="/modules/education/education.php?id=<?php echo $output["id"]; ?>">

						<div class="difficultyPos"><?php echo $output["difficulty"]; ?></div>

						<!-- Section - image -->
						<div class="col-full">
							<div class="wrap-col">
								<figure class="circleImg">
									<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="<?php echo $output["title"]; ?>">
								</figure>
							</div>
						</div>

						<!-- Section - title and text -->
						<div class="col-full">
							<div class="wrap-col">
								<h3 class="wordSplit"><?php echo $output["title"]; ?></h3>
								<p><?php echo $functions->ellipsis($output["content"], 300); ?></p>
							</div>
						</div>
					</a>

					<?php if(isset($_SESSION["privilege"]) >= "4"){ ?>
						<!-- hidden settings -->
						<div class="forumBarSetting forumBoxHidden">
							<a href="/modules/education/editEducation.php?id=<?php echo $output["id"]; ?>">
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="/resources/images/svg/editor-pencil-pen-edit-write-glyph.svg" alt="">Ändra
							</a>
						</div>
					<?php } ?>

				</div>

			<?php } ?>

		</div>
	</div>
</div>