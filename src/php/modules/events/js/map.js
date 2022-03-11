$(document).ready(function () {

    var place;
    
    /*function getDiagram(place){
        console.log(place);
        let typeLabelArray = [],
        typePercentValueArray = [];

        $.post("/modules/events/getEventCrimeDiagramInformation.php", { "place": place }, function (data) {

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
                    plugins: {
                        labels: {
                            render: "value",
                        }
                    },
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
                            left: 100,
                            right: 50,
                            top: 100,
                            bottom: 100
                        }
                    }
                }
            });

        }, "json");

    }*/
 
    /*var map = new ol.Map({
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

    map.getView().setCenter(ol.proj.transform([13.2730471, 59.8946925], 'EPSG:4326', 'EPSG:3857'));*/

    /*$('.searchButton').on('click', function () {
        let searchValue = searchResult();
        getLocation(searchValue);
    });*/

    /*$('.openSearchButton').on('click', function () {
        toggleSideMenu();
    });*/ 

    /*$('#diagramButton').on('click', function () {
        $(".chart-container").html('<canvas id="myChart"></canvas>');
        getDiagram(place);

    });*/

    $('#searchInput').on('input', function (c) {

        let searchValue = searchResult();
        let outputBox = $(".searchResults");
        
        outputBox.css("display", "none");
        outputBox.empty();

        if(searchValue.length >= 2){
            
            let output = "",
                output2 = "",
                outputLink = "",
                title = "";

            outputBox.css("display" , "block");
            $.post("/modules/events/getEventSearchResults.php", { "searchValue": searchValue }, function (data) {
                $.each(data, function (index, value) {

                    if(value.name){
                        
                        if(value.mun){
                            title = value.mun;
                            output2 = "län";
                        }else{
                            title = value.dis;
                            output2 = "kommun";
                        }

                        output = value.name + " <span class='searchSub'>(" + title + " " + output2 + ")</span>";
                        outputLink = value.name;
                    }else{
                        output = value.title + " län";
                        outputLink = value.title;
                    }

                    if(outputBox.is(":empty")){
                        outputBox.append("<a class='select' href='#' data-section-id='" + outputLink + "'>" + output + "</a>"); 
                    }else{
                        outputBox.append("<a href='#' data-section-id='" + outputLink + "'>" + output + "</a>");
                    }
                    
                });

            },"json");

        }
        
    });

    $('.searchResults').on('click', 'a', function () {
        let searchValue = $(this).attr("data-section-id");
            //place = searchValue;
            //getLocation(searchValue);
            //getInformation(searchValue);
            window.location.replace("/modules/events/eventsview.php?place="+searchValue);
    });

    $('#searchInput').on('keypress', function (e) {
        if (e.which == 13) {
            let searchValue = $('.searchResults .select').attr("data-section-id");
            //place = searchValue;
            //getLocation(searchValue);
            //getInformation(searchValue);
            window.location.replace("/modules/events/eventsview.php?place="+searchValue);
            
        }
    });

    //functions
    /*function outputInformation(data) {
        let title = "";

        if(data.name){
            title = data.name;
        }else{
            title = data.title;
        }
        $('#searchInformation h2').text(title);
        $('#searchInformation h2').text(title);
    }*/

    /*function toggleSideMenu() {
        //$('.overlaySearchBox').stop().animate({ width: 'toggle' }, 350);

        $('#searchInformation').stop().animate({ width: 'toggle' }, 350);

        if($("#crimeInformation").css("display") === "block"){
            $("#crimeInformation").stop().animate({width: 'toggle'}, 0);
        }
        
    }*/

    /*function getInformation(place) {
        let outputBox = $('#searchInformation p');
        outputBox.empty();

        $.post("/modules/events/getEventInformation.php", { "place": place }, function (data) {

            outputBox.html("<div class='col-8-12'><div class='wrap-col'><img class='eventImage' src='/resources/images/svg/steal.svg'> Antal händelser: " + data + "</div></div><div class='col-4-12'><div class='wrap-col'><div class='crimeInfoButton' href='#' title='Visa brottsdetaljer'>Visa mer</div></div></div>");
        
        }, "json");
    }*/

    /*function getCrimeInformation(place) {
        let outputBox = $('#crimeInformation p');
        outputBox.empty();
        $(".chart-container").empty();

        $.post("/modules/events/getEventCrimeInformation.php", { "place": place }, function (data) {

            $.each(data, function (index, value) {

                outputBox.append("<div class='col-4-12'><div class='wrap-col'>" + index + "<div class='infoBoxType'><div class='infoBoxTypeNumber'>" + value + "</div></div></div></div>");

            });

        }, "json");
    }*/

    /*function getLocation(value) {
        $(".searchResults").empty();
        $(".searchResults").css("display", "none");
        
        $.post("/modules/events/getEventLocations.php", { "searchValue": value }, function (data) {

            if(data !== null){
                toggleSideMenu();
                CenterMap(data.longitude, data.latitude, data.zoom);
                
                if(data.polygon >= 1){
                    polygon(data);
                }
            }
            
            outputInformation(data);
        },"json");

        $("#searchInput").val("");
    }*/

    /*function CenterMap(long, lat, zoomValue) {
        map.getView().setCenter(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857'));
        map.getView().setZoom(zoomValue);
    }*/

    function searchResult() {
        let result = false;
        let userInput = $('#searchInput').val();

        if (userInput) {
            result = userInput;
        }

        return result;
    }

    /*function polygon(obj) {

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
    }*/

});