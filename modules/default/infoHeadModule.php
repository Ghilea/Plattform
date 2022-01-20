<?php //$infoHead = new Infohead($database); ?>

<div class="style indexBanner">
	<div class="container m-center">

	<?php foreach($functions->getBanner() as $output) { ?>

		<h2><?php echo $output["name"]; ?></h2>
		<p><?php echo $output["content"]; ?></p>

	<?php } ?>
	
	</div>
</div>