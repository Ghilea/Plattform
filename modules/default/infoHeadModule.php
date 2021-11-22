<?php //$infoHead = new Infohead($database); ?>

<div class="style indexBanner">
	<?php foreach($functions->getBanner() as $output) { ?>

		<h2><?php echo $output["name"]; ?></h2>
		<p><?php echo $output["content"]; ?></p>

	<?php } ?>
	
</div>