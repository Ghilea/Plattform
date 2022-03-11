<?php $class = new Gallery($database, $functions); ?>

<section class="style gallery">

	<header>
		<?php foreach($class->getHeader() as $hOutput){ ?>
			<h2><?php echo $hOutput["name"]; ?></h2>
			<p><?php echo $hOutput["content"]; ?></p>
		<?php } ?>
	</header>

	<div class="container row">
	<?php foreach($class->getGallery() as $output) { ?>
		
		<figure>
			<img src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="<?php echo $output["title"]; ?>">
			<figcaption>
				<h3><?php echo $output["title"]; ?></h3>
				<!--<p><?php echo $output["content"]; ?></p>-->
			</figcaption>
		</figure>

	<?php } ?>
	</div>

</section>