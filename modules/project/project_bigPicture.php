<?php $Project = new Project($database, $functions); ?>

	<div class="knowledge">

		<?php foreach($Project->getSkills() as $output) { ?>

			<figure class="<?php echo $output["class"]; ?>">
				
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["link"]; ?>" title="<?php echo $output["name"]; ?>" alt="<?php echo $output["name"]; ?>">

				<figcaption><?php echo $output["name"]; ?></figcaption>
			</figure>

		<?php } ?>

	</div>

	<div class="spawn">
	<?php for($x = 0; $x <= 10; $x++){?>
		<span></span>
	<?php } ?>
	</div>