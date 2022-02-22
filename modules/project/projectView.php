<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php"); ?>

<?php $class = new Project($database, $functions); ?>

<?php $output = $class->getProject($_GET["id"]); ?>

<main class="project">
	<div class="container view">
		<section class="container row">
			<p><a rel="noreferrer noopener" href="/index.php#project" title="Gå tillbaka">Hem</a> -> <?php echo $output["title"]; ?></p>
		</section>

		<h1><?php echo $output["title"]; ?></h1>
		<section class="container row">
			<article>
				<h2>Bakgrundshistoria</h2>
				<p><?php echo $output["content"]; ?></p>
			</article>	
			
			<?php if($output["link"] !== null) { ?>
				<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link"]; ?>" class="boxBtn">Live Demo</a>
			<?php } ?>

			<?php if($output["link2"] !== null) { ?>
			<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link2"]; ?>" class="boxBtn">GitHub</a>
			<?php } ?>
		</section>

		<section class="toolImg">
			<?php foreach($output["images_skill"] as $output2) { ?>
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output2["image_link"]; ?>" title="<?php echo $output2["name"]; ?>" alt="">
			<?php } ?>
		</section>

		<section class="container row">
			<figure>	
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="">
			</figure>
		</section>

		<section class="workFlow">
			<?php foreach ($output["workflow"] as $output3) { ?>
			<article>
				<p><?php echo $functions->formatText($output3["content"]); ?></p>
				<figure>
					<img src="<?php echo $output3["img"]; ?>" alt="">
					<figcaption>
						<?php echo $output3["name"]; ?>
					</figcaption>
				</figure>
			</article>
			<?php } ?>
		</section>
		
	</div>
</main>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>