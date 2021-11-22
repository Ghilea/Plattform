<?php $news = new News($database, $functions); ?>

<div class="styleNews">

	<div class="col-full">
		<div class="flex-container">

			<?php foreach($news->getNews() as $output) { ?>
				<div class="<?php echo $output["rowClass"]; ?>  col-6-12m boxnews">
					<div class="wrap-col">

						<a href="#<?php echo $output["id"]; ?>">

							<?php if ($output["rowClass"] != "col-6-12m col-full") { ?>
 
							<h3 title="<?php echo $output["title"]; ?>"><?php echo $output["title"]; ?></h3>

							<!-- Section - image -->
							<div class="col-6-12">
								<div class="wrap-col">
		
									<figure class="img">
										<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=" <?php echo $output["image"] ?>" title="<?php echo $output["title"]; ?>" alt="">
									</figure>
			
								</div>
							</div>

							<!-- Section - title and text -->
							<div class="newsTextBox col-6-12">
								<div class="wrap-col">

									<p><?php echo $functions->ellipsis($output["content"], 200); ?></p>

								</div>
							</div>

							<?php } else {?>

								<!-- Section - title and text -->
							<div class="col-6-12">
								<div class="wrap-6-12">
			
									<h3 title="<?php echo $output["title"]; ?>"><?php echo $output["title"]; ?></h3>
									<p><?php echo $functions->ellipsis($output["content"], 200); ?></p>

								</div>
							</div>

							<!-- Section - image -->
							<div class="col-6-12">
								<div class="wrap-6-12">
		
									<figure class="img">
										<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=" <?php echo $output["image"] ?>" title="<?php echo $output["title"]; ?>" alt="">
									</figure>
			
								</div>
							</div>

							<?php } ?>
						</a>

					</div>
				</div>
					
			<?php } ?>

		</div>
	</div>

</div>