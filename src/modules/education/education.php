<?php include_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$myBBCode = new BBCode();

$education = new Education($database, $functions);
$view = $education->getEducation();

?>

<!-- section1 -->
<div class="styleLight">

	<!-- header -->
	<div class="col-full headerBox">
		<div class="bgBox">
				
			<div class="content">
				<div class="col-full">
					<div class="wrap-col">
						<figure class="circleImg">
							<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $view["image"]; ?>" title="<?php echo $view["title"]; ?>" alt="<?php echo $view["title"]; ?>">
						</figure>
						<p><?php echo $myBBCode->useBBCode($view["content"]); ?></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- header -->
		<header>
			
			<!-- index -->
			<div class="col-full">
				<div class="wrap-col">
					<div class="eduMenu">
						<a href="/index.php#education">Kurser</a> &gt;
						<?php echo $view["title"]; ?>
					</div>
				</div>
			</div>

		</header>

	<div class="col-full">
		<div class="wrap-col">
			<div class="content">
				
				<div class="flex-container">

					<?php foreach($education->getEducationTask() as $output){ ?>

						<div class="col-6-12 col-6-12m">
							<div class="wrap-col boxForum borderWhiteLeft">

								<a href="/modules/education/educationView.php?id=<?php echo $output["id"]; ?>">
									<h2><?php echo $output["title"]; ?></h2>
									<p><?php echo $functions->ellipsis($output["content"]); ?></p>
								</a>

							</div>
						</div>

					<?php } ?>

				</div>

			</div>
		</div>
	</div>
	
</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>