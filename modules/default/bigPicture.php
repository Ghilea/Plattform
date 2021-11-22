<?php //$infoHead = new Infohead($database); ?>

<div class="style bigPicture">

	<div class="container column">

		<div class="bigPictureText">
			<?php foreach ($functions->headModuleText() as $output) {  ?>
				<div class="<?php echo $output["class"]; ?>"><?php echo $output["name"]; ?></div>
			<?php } ?>
		</div>

	</div>

	<?php require_once($_SERVER['DOCUMENT_ROOT'].$functions->headRightModule()); ?>

</div>