<?php include_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$events = new Events($database, $functions);
$events->addGetPost();
$listView = $events->getTypeList();
$type = $events->getType();
?>

<!-- section1 -->
<div class="styleLight">

	<div class="col-full">
		<div class="wrap-col">
			<div class="content">

				<div class="col-3-12 col-4-12m">
					<div class="wrap-col">

						<h3>Typ av händelse</h3>
							
						<?php foreach($type as $index => $vale){ ?>
							<a href="/modules/events/eventsList.php?place=<?php echo $events->place; ?>&type=<?php echo $index; ?>">
								<div class="col-full">
									<div class="wrap-col boxForum borderBlueLeft">
										<h2><?php echo $index; ?></h2>
									</div>
								</div>
							</a>
						<?php }?>
							
					</div>
				</div>
		
				<div class="col-9-12 col-8-12m">
					<div class="wrap-col">
										
						<h3><?php echo $events->place; ?></h3>

						<?php foreach($listView as $output){ ?>
							<a href="<?php echo $output["link"]; ?>">
								<div class="col-full">
									<div class="wrap-col boxForum borderBlueLeft">
										<h2><?php echo $output["name"]; ?></h2>

										<p><?php echo $output["content"]; ?></p>

									</div>
								</div>
							</a>
						<?php }?>

					</div>
				</div>

			</div>
		</div>
	</div>

</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>