<?php //$infoHead = new Infohead($database); ?>

<section class="container-fluid style hero">
	<header>
		<h1>
			<?php foreach ($functions->headModuleText() as $output) {  ?>
			<div class="<?php echo $output["class"]; ?>">
				<?php echo $output["name"]; ?>
			</div>
			<?php } ?>
		</h1>
	</header>

	<?php //require_once($_SERVER['DOCUMENT_ROOT'].$functions->headRightModule()); ?>

	<!-- bubble -->
	<?php for($x = 0; $x <= 15; $x++){?>
		<div class="bubbles"></div>
	<?php } ?>

</section>