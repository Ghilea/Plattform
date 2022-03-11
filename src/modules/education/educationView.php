<?php include_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$myBBCode = new BBCode();

$education = new Education($database, $functions);
$view = $education->getEducationTaskView();
//print_r($view);
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
								<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $view["view"]["image"]; ?>" title="<?php echo $view["view"]["title"]; ?>" alt="<?php echo $view["view"]["title"]; ?>">
							</figure>
							<h2><?php echo $view["view"]["title"]; ?></h2>
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
						<a href="/modules/education/education.php?id=<?php echo $view["view"]["id"]; ?>"><?php echo $view["view"]["education_title"]; ?></a> &gt;
						<?php echo $view["view"]["title"]; ?>
					</div>
				</div>
			</div>
		</header>

		<div class="col-full">
			<div class="wrap-col">
				<div class="content">

					<div class="col-3-12 col-4-12m">
						<div class="wrap-col">

							<div class="task">
								<h3>Video</h3>
								<ul>
									<?php foreach($view["video"] as $output){ ?>
										<div class="js-overlay-start" data-url="<?php echo $output["link"]; ?>?rel=0&amp;showinfo=0&amp;autoplay=1">
											<li class="boxForum borderBlueLeft"><?php echo $output["title"]; ?></li>
										</div>
									<?php } ?>
								</ul>

								<h3>Övningar</h3>
								<ul>
									<?php foreach($view["task"] as $output){ ?>
										<a href="#">
											<li class="boxForum borderGreenLeft"><?php echo $output["title"]; ?></li>
										</a>
									<?php } ?>
								</ul>
							</div>

						</div>
					</div>
		
					<div class="col-9-12 col-8-12m">
						<div class="wrap-col">
							
							<div class="flex-container">
									
								<!-- information -->
								<div class="col-full">
									<div class="wrap-col">
										<p><?php echo $myBBCode->useBBCode($view["view"]["content"]); ?></p>
									</div>
								</div>

							</div>

						</div>
					</div>

			</div>
		</div>
	</div>

</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>