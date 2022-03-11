<?php //$infoHead = new Infohead($database); ?>

<section class="container-fluid style hero">
	<header>
		
	<?php foreach ($functions->headModuleText() as $output) {  ?>
	
	<?php if($output["class"] == "button"){ ?>	
		<a href="<?php echo $output["link"]; ?>" class="<?php echo $output["class"]; ?>">
			<?php echo $output["name"]; ?>
		</a>
	<?php } else { ?>
		<h1 class="<?php echo $output["class"]; ?>">	
			<?php echo $output["name"]; ?>
		</h1>
	<?php } } ?>
		
	</header>

	<?php //require_once($_SERVER['DOCUMENT_ROOT'].$functions->headRightModule()); ?>

	<!-- bubble -->
	<?php for($x = 0; $x <= 15; $x++){?>
		<div class="bubbles"></div>
	<?php } ?>

</section>