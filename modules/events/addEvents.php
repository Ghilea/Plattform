<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/includes/connection.php');

//settings
$getDataEachTurn = 25;

$postData = ["data", "countCheck", "pos", "content", "dataAdded"];

foreach($postData as $value) { 
	if (isset($_POST[$value])) { ${$value} = $_POST[$value]; }else{ ${$value} = null; }
}

$data = json_decode(file_get_contents("https://polisen.se/api/events"), true);

$addItems = [];
$x = 0;

foreach($data as $addData){

	$countCheck = $database->count("events", ["externId" => $addData["id"]]);
	$checkList = "Trafikolycka Trafikolycka, vilt Trafikolycka, singel, Sammanfattning natt, Sjukdom/olycksfall, Trafikolycka, personskada, Övrigt, Försvunnen person, Arbetsplatsolycka, Trafikhinder, Trafikkontroll, Räddningsinsats, Djur, Trafikbrott, Uppdatering, Sammanfattning kväll och natt, Polisinsats/kommendering, Sammanfattning dag";

	if($countCheck <= 0 && strpos($checkList, $addData["type"]) === false){
		echo $addData["type"]."<br>";
		$addItems[$x] = $data[$x];	
	}
	$x++;

	if(count($addItems) >= $getDataEachTurn){
		break;
	}
}

$data = $addItems;

//location, split up
if($data !== null){

	$dbarea;
	$found = false;
	$i = 0;

	foreach($data as $output){

		$pieces = explode(",", $output["location"]["gps"]);
		$latitude = $pieces[0];
		$longitude = $pieces[1];

		//get string from url
		$content = file_get_contents($output["url"]);

		//string starts from
		$pos = stripos($content,'<div class="event-content">');

		//if start position exist
		$content = substr($content,$pos);

		//end position
		$pos = strripos($content,'<div class="block blue-line">');

		$area = utf8_encode(substr($content, 0, $pos));

		$area = strip_tags($area);

		$area = str_replace("<br>", "", $area); 
		
		//fix åäö
		$area = cleanString($area);

		//print_r($area);
		$getDBArea = $database->select("region_municipality",
		["[><]region_district" => ["region_municipality_id" => "id"]],
		["region_district.name"],
		["region_municipality.title" => $output["location"]["name"]]);

		print_r($getDBArea);

		if($getDBArea >= 1){
			foreach($getDBArea as $show){
				if (preg_match($show["title"], $area)) {
					$found = true;
					$dbarea = $show["title"];
				}else{
					$found = false;
				}
			}
		}
		//check if externalId exist in db
		$countCheck = $database->count("events", ["externId" => $output["id"]]);

		if($countCheck <= 0){			

			//insert to db
			$database->insert("events",
			[
				"externId" => $output["id"],
				"name" => $output["name"],
				"content" => $output["summary"],
				"link" => $output["url"],
				"linkContent" => $area,
				"type" => $output["type"],
				"location" => $output["location"]["name"],
				"area" => $found ? $dbarea : null,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"externDate" => $output["datetime"],
			]);

		}

		$i++;

	}

	echo count($data)." st händelser inlagd";
	
}else{
	echo "Det finns inga nya händelser att lägga till";
}

function cleanString($string) {
	$checkList = [
		["check" => '/\W*((?i)&aring;(?-i))\W*/', "replace" => "å"], 
		["check" => '/\W*((?i)&auml;(?-i))\W*/', "replace" => "ä"], 
		["check" => '/\W*((?i)&ouml;(?-i))\W*/', "replace" => "ö"],
		["check" => '/\W*((?i)&nbsp;(?-i))\W*/', "replace" => " "]
		
	];

	foreach($checkList as $output){
		$string = preg_replace($output["check"], $output["replace"], $string);
	}
	
   return trim($string);
}

function getCoordination($address, $city){
        $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
        
        //$url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
		
		$url = "https://nominatim.openstreetmap.org/search.php?q='$address'%2C+'$city'";

        $response = file_get_contents($url);
        
        $json = json_decode($response,TRUE); //generate array object from the response from the web

        $latitude = ($json["results"][0]["geometry"]["location"]["lat"]);
        $longitude = ($json["results"][0]["geometry"]["location"]["lng"]);

        return array("latitude" => $latitude, "longitude" => $longitude);
    }
?>