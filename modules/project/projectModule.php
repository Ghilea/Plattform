<?php $class = new Project($database, $functions); ?>

<section class="container-fluid project">
	
	<header>
		<h2>Kunskaper</h2>	
	</header>

	<div class="container skills">

		<?php foreach($class->getSkills() as $output) { ?>

			<figure <?php if(isset($output["class"])){ ?>class="<?php echo $output["class"]; ?>" <?php } ?>>
				
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>" alt="<?php echo $output["name"]; ?>">

				<figcaption><?php echo $output["name"]; ?></figcaption>
			</figure>

		<?php } ?>

	</div>

	<header id="project">
		<?php foreach($class->getHeader() as $hOutput){ ?>
			<h2><?php echo $hOutput["name"]; ?></h2>
			<p><?php echo $hOutput["content"]; ?></p>
		<?php } ?>		
	</header>

	<div class="container projectBox">

	<?php foreach($class->getProject() as $output) {  ?>
		
		<article class="container row">
			
			<div class="leftPanel">

				<figure>	
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="">
				</figure>

			</div>

			<div class="centerPanel">

				<?php foreach($output["images_skill"] as $output2) { ?>
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output2["image_link"]; ?>" title="<?php echo $output2["name"]; ?>" alt="">
				<?php } ?>

			</div>

			<div class="rightPanel">
		
				<h3><?php echo $output["title"]; ?></h3>
							
				<p><?php echo $functions->ellipsis($output["content"], 200); ?><a href="./modules/project/projectView.php?id=<?php echo $output["id"]; ?>">Läs mer</a></p>
				
				
				<?php if($output["showBtn"] == 1 ){?>
			
					<?php if($output["link"] !== null) { ?>
					<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link"]; ?>" class="boxBtn buttonLeft">Live Demo</a>
					<?php } if($output["link2"] !== null) { ?>
				
					<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link2"]; ?>" class="boxBtn buttonRight">GitHub</a>
		
				<?php } } ?>
				
			</div>
			
		</article>
				

	<?php } ?>

	</div>
</section>