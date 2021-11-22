<?php $class = new Project($database, $functions); ?>

<section class="style project">
	
	<header>
		<?php foreach($class->getHeader() as $hOutput){ ?>
			<h2><?php echo $hOutput["name"]; ?></h2>
			<p><?php echo $hOutput["content"]; ?></p>
		<?php } ?>		
	</header>

	<div class="container row">
	<?php foreach($class->getProject() as $output) { ?>

		<div class="box">
			
			<figure class="mainImg">	
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=" <?php echo $output["image"]; ?>" title="<?php echo $output["title"]; ?>" alt="">
			</figure>

			<h3 title="<?php echo $output["title"]; ?>"><?php echo $output["title"]; ?></h3>
			<p><?php echo $functions->ellipsis($output["content"], 200); ?></p>
				
			<?php if($output["showBtn"] >= 1 ){?>
			
				<a rel="noreferrer noopener" target="_blank" href="#<?php echo $output["link"]; ?>" class="boxBtn buttonLeft">Live Demo</a>
				
				<a rel="noreferrer noopener" target="_blank" href="<?php echo $output["link2"]; ?>" class="boxBtn buttonRight">GitHub</a>
		
			<?php }else{ ?>

				<figure class="underConstruction">
					<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=" <?php echo $output["link2"] ?>" title="Under Utevckling" alt="">
					<figcaption><?php echo $functions->ellipsis("Under Utevckling", 200); ?></figcaption>
				</figure>

			<?php } ?>

		</div>

	<?php } ?>
	</div>

</section>