<?php $class = new Settings($database, $functions); ?>

<section class="style settings">
	
	<header>
		<h2><?php echo $class->getHeader(); ?></h2>
	</header>

	<div class="container row">

		<div class="buttonContent column">
			<?php foreach($class->getMenuButtons() as $outputBtn) { ?>		
				<label class="button" for="<?php echo $outputBtn["class"]; ?>">
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $outputBtn["link"]; ?>" title="<?php echo $outputBtn["name"]; ?>" alt="<?php echo $outputBtn["name"]; ?>">
				</label>
				<input type="checkbox" id="<?php echo $outputBtn["class"]; ?>">
			<?php } ?>
		</div>

		<div id="modulesContent" class="column hiddenContent">
			<?php foreach($class->getModules() as $output) { ?>
				<div class="content row">
					<h3><?php echo $output["moduleName"]; ?></h3>
					<label class="switch" for="<?php echo $output["moduleName"]; ?>">
						<input type="checkbox" id="<?php echo $output["moduleName"]; ?>" <?php if($output["moduleOn"]) { ?> checked="checked" <?php } ?> value="<?php echo $output["id"]; ?>">
						<span class="slider"></span>
				
					</label>
				</div>
			<?php } ?>
		</div>

		<div id="configsContent" class="hiddenContent column">
			<?php foreach($class->getConfigs() as $output) { ?>
				
				<input type="checkbox" id="configID_<?php echo $output["id"]; ?>" class="configsContent__title">[<?php echo $output["type"]; ?>] - <?php echo $output["name"]; ?>

				<label for="configID_<?php echo $output["id"]; ?>" class="content row configsContent__toggleBox">
					<h3>Typ</h3>
					<input type="text" value="<?php echo $output["type"]; ?>">

					<h3>Namn</h3>
					<input type="text" value="<?php echo $output["name"]; ?>">

					<h3>Text</h3>
					<input type="text" value="<?php echo $output["content"]; ?>">

					<h3>Bild</h3>
					<input type="text" value="<?php echo $output["image"]; ?>">

					<h3>Länk</h3>
					<input type="text" value="<?php echo $output["link"]; ?>">

					<label class="switch" for="<?php echo $output["name"]; ?>">
						<input type="checkbox" id="<?php echo $output["name"]; ?>" <?php if($output["active"]) { ?> checked="checked" <?php } ?> value="<?php echo $output["id"]; ?>">
						<span class="slider"></span>
				
					</label>

				</label>
			<?php } ?>
		</div>

	</div>

</section>