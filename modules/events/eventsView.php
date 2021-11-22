<?php include_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/header.php");

$myBBCode = new BBCode();

$events = new Events($database, $functions);
$events->addGetPost();
$diagram = $events->getDiagram();
$link = $events->getInformation();
$crimeInfo = $events->getCrimeInformation();
$location = $events->getLocation();

?>

<!-- section1 -->
<div class="styleLight">

	<!-- header -->
		<div class="col-full ">
			<div id="map"></div>
		</div>

		<!-- header -->
		<header>
			<!-- index -->
			<div class="col-full">
				<div class="wrap-col">
					<div class="eduMenu">
						<h2><?php echo $events->place; ?></h2>
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
								<h3>Överblick</h3>
								<?php echo $link; ?>
							</div>

							<div class="task">
								<h3>Område</h3>
								Fakta<br>
								Försäkringspremier								
							</div>

						</div>
					</div>
		
					<div class="col-9-12 col-8-12m">
						<div class="wrap-col">
							
							<div class="flex-container">
									
								<!-- information -->
								<div class="col-full">
									<div class="wrap-col">

									<div class="chart-container">
											<canvas id="myChart"></canvas>
										</div>

									<?php foreach($crimeInfo as $index => $value){ ?>
										<a href="eventsList.php?place=<?php echo $events->place; ?>&type=<?php echo $index; ?>">
										<div class='col-4-12 hover'>
											<div class='wrap-col'>
												<?php echo $index; ?>
											
												<div class='infoBoxType'>
													<div class='infoBoxTypeNumber'>
														<?php echo $value; ?>
													</div>

												</div>
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
		</div>
	</div>

</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']."/resources/includes/footer.php"); ?>

<script type="text/javascript">
window.onload = function() {

	var coord = <?php echo json_encode($location, JSON_PRETTY_PRINT); ?>

	var map = new ol.Map({
        interactions: ol.interaction.defaults({
            doubleClickZoom: false,
            dragAndDrop: false,
            dragPan: false,
            keyboardPan: false,
            keyboardZoom: false,
            mouseWheelZoom: false,
            pointer: false,
            select: false
        }),
        controls: ol.control.defaults({
            attribution: false,
            zoom: false,
        }),
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        target: 'map',
        view: new ol.View({
            center: [0, 0],
            zoom: 6
        })
	});
	
	if(coord !== null){
		CenterMap(coord.longitude, coord.latitude, coord.zoom);
		
		if(coord.polygon >= 1){
			polygon(coord);
		}
	}

	function CenterMap(long, lat, zoomValue) {
        map.getView().setCenter(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857'));
        map.getView().setZoom(zoomValue);
	}

	function polygon(obj) {

        var points = $.parseJSON(obj.polygon);
        var polygon = new ol.geom.Polygon([points]);
        polygon.transform('EPSG:4326', 'EPSG:3857');

        // Create feature with polygon.
        var feature = new ol.Feature(polygon);

        // Create vector source and the feature to it.
        var vectorSource = new ol.source.Vector();
        vectorSource.addFeature(feature);

        // Create vector layer attached to the vector source.
        var vectorLayer = new ol.layer.Vector({
            source: vectorSource
        });

        // Add the vector layer to the map.
        map.addLayer(vectorLayer);
    }
	
	getDiagram();
    
    function getDiagram(){
		
        let typeLabelArray = [],
		typePercentValueArray = [],
		data = <?php echo json_encode($diagram, JSON_PRETTY_PRINT); ?>;

		$.each(data, function (index, value) {
            typeLabelArray.push(index);
            typePercentValueArray.push(value);
		});

		var ctx = document.getElementById('myChart').getContext('2d');

		new Chart(ctx, {
			// The type of chart we want to create
			type: 'bar',

			// The data for our dataset
			data: {
				labels: typeLabelArray,
				datasets: [{
					backgroundColor: 'rgba(0, 126, 167,0.5)',
					borderColor: 'rgb(255, 255, 255)',
					borderWidth: 1,
					data: typePercentValueArray
				}]
			},

			// Configuration options go here
			options: {
				scales: {

					yAxes: [{
						ticks: {
							min: 0,
							max: 100,
							callback: function (value) { return value + "%" }
						},
						scaleLabel: {
							display: true,
							labelString: "Procent"
						}
					}]
				},

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
						right: 450,
						top: 0,
						bottom: 50
					}
				}
			}
		});

    }

};
</script>