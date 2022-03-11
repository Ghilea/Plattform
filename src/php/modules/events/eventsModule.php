<?php 

$events = new Events($database, $functions);
$region_mun = $events->getRegionMun();
$high = $events->records($region_mun, 5,"high");
$low = $events->records($region_mun, 10, "low");

?>
<div class="styleEvents">
	<div class="col-full">
		<h2>Händelser</h2>
		
		<div class="col-full">
			<div class="wrap-col">
				<div class="content">
					
					<p>Kommuner med flest händelser</p>

					<div class="col-6-12 col-6-12m">
						<div class="wrap-col">

							<div class="chart-container">
								<canvas id="highestChart"></canvas>
							</div>

						</div>
					</div>
		
					<div class="col-6-12 col-6-12m">
						<div class="wrap-col">
							
							<div class="flex-container">
									
								<!-- information -->
								<div class="col-full">
									<div class="wrap-col">

										<?php foreach($high as $output){ ?>
										<a href="/modules/events/eventsView.php?place=<?php echo $output["title"]; ?>">
										<div class="col-full">
											<div class="wrap-col boxForum borderRedLeft">
												<h2><?php echo $output["title"]; ?></h2>

												<p>
													<?php echo $output["value"]; ?> st händelser
												</p>

											</div>
										</div>
													</a>
										<?php } ?>
											
									</div>
								</div>

								
							</div>

						</div>
					</div>

					<div class="col-full">
						<div class="wrap-col">

							<p>Kommuner med minst händelser</p>

							<div class="flex-container">
									
								<!-- information -->
								<div class="col-full">
									<div class="wrap-col">

										<?php foreach($low as $output){ ?>
										<a href="/modules/events/eventsView.php?place=<?php echo $output["title"]; ?>">
										<div class="col-6-12 col-6-12m">
											<div class="wrap-col boxForum borderGreenLeft">
												<h2><?php echo $output["title"]; ?></h2>

												<p>
													<?php echo $output["value"]; ?> st händelser
													<?php if($output["value"]> 0){ ?>, varav <?php echo $output["eventsTitle"]; ?> (<?php echo $output["eventsValue"]; ?> st) är det som begåtts flest gånger.
													<?php } ?>
												</p>

											</div>
										</div>
													</a>
										<?php } ?>
											
									</div>
								</div>

							</div>

						</div>
					</div>

			</div>
		</div>
	</div>

	</div>
</div>

<script type="text/javascript">
window.onload = function() {
	
	getDiagram();
    
    function getDiagram(){
		
        let typeLabel = [],
		typeValue = [];
		
		higestData = <?php echo json_encode($high, JSON_PRETTY_PRINT); ?>;

		$.each(higestData, function (index, data) {
            typeLabel.push(data.title);
            typeValue.push(data.value);
		});

		var highestCtx = document.getElementById('highestChart').getContext('2d');

		new Chart(highestCtx, {
			type: 'pie',
			data: {
				labels: typeLabel,
				datasets: [{
					backgroundColor: 'rgba(0, 126, 167,0.5)',
					borderColor: 'rgb(255, 255, 255)',
					borderWidth: 1,
					data: typeValue
				}]
			},

			// Configuration options go here
			options: {
				
				responsive: true,
				legend: {
					display: false
				}, 
				animation: {
					animateScale: true,
					animateRotate: true
				},
				layout: {
					padding: {
						left: 0,
						right: 520,
						top: 50,
						bottom: 200
					}
				}
			}
		});

    }

};
</script>