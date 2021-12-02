<?php $class = new Project($database, $functions); ?>

<section class="container-fluid style project">
	
	<header>
		<h2>Kunskaper</h2>	
	</header>

	<div class="container row">

		<?php foreach($class->getSkills() as $output) { ?>

			<div class="col-lg-3 col-md-4 col-sm-6">

				<figure class="<?php echo $output["class"]; ?>">
					
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>" alt="<?php echo $output["name"]; ?>">

					<figcaption><?php echo $output["name"]; ?></figcaption>
				</figure>
			
			</div>

		<?php } ?>

	</div>

	<header id="project">
		<?php foreach($class->getHeader() as $hOutput){ ?>
			<h2><?php echo $hOutput["name"]; ?></h2>
			<p><?php echo $hOutput["content"]; ?></p>
		<?php } ?>		
	</header>

	<?php foreach($class->getProject() as $output) {  ?>
		
		<article class="container row">
			<div class="leftPanel col-sm-12 activate3d">
				<figure class="box3d">	
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="">
				</figure>
			</div>
			<div class="centerPanel">
				<?php foreach($output["images_skill"] as $output2) { ?>
					
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output2["image_link"]; ?>" title="<?php echo $output2["name"]; ?>" alt="">
				<?php } ?>
			</div>
			<div class="rightPanel col-sm-12 activate3d">
				<div class="box3d">
					<h3><?php echo $output["title"]; ?></h3>
								
					<details>
						<summary>Visa mer</summary>
						<p><?php echo $output["content"]; ?></p>
					</details>

					<p><?php echo $functions->ellipsis($output["content"], 200); ?></p>
					
					<?php if($output["showBtn"] >= 1 ){?>
				
						<a rel="noreferrer noopener" target="_blank" href="#<?php echo $output["link"]; ?>" class="boxBtn buttonLeft">Live Demo</a>
					
						<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link2"]; ?>" class="boxBtn buttonRight">GitHub</a>
			
					<?php }else{ ?>

						<figure class="underConstruction">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=" <?php echo $output["link2"] ?>" title="Under Utevckling" alt="">
							<figcaption><?php echo $functions->ellipsis("Under Utevckling", 200); ?></figcaption>
						</figure>

					<?php } ?>
				</div>
			</div>
			
		</article>
				

	<?php } ?>

</section>