<?php

class Events {

    public string $place;
    public string $type;

    public function __construct($database = null, Functions $functions = null){
        $this->db = $database;
        $this->fk = $functions;
    }

    public function addGetPost(){

        if(isset($_GET["place"])){
            $this->place = $_GET["place"];

            $check = $this->db->has("region_municipality", [
            "AND" => ["title" => $this->place]
            ]);

            if($check == false){
                header("Location: /index.php"); exit;
            }
        }else{
            header("Location: /index.php"); exit;
        }

        if(isset($_GET["type"])){
            $this->type = $_GET["type"];
        }

    }

    public function getRegionMun(){
        $res2 = [];

        $region_mun = $this->db->select("region_municipality", 
        ["title"]);

        foreach($region_mun as $output){
            $res2[$output["title"]] = $this->db->count("events", 
            ["location"],
            ["location" => $output["title"]]);
        }

        return $res2;
    }

    public function records(array $res2, int $countAdd, string $type){
        $newArray = [];

        if($type == "high"){
            arsort($res2);
        }else if($type == "low"){
            asort($res2);
        }

        for($x = 0; $x < $countAdd; $x++){

            $index = key($res2);
            $value = array_values($res2);

            $newArray[] = ["title" => $index, "value" => $value[0]];
            array_shift($res2);
        }
        
        return $newArray;
    }

    public function getType(){

        $query = $this->db->select("events",
        [       
            "type",
        ],
        ["AND" => ["location" => $this->place]]);

        $res = [];
        $newArray = [];

        foreach($query as $value){
            $new = strtok($value["type"], ",");
            $new = strtok($new, "/");
            $new = str_replace(' övrigt', '', $new);
            $newArray[]["type"] = $new; 
        }

        $res = array_count_values(array_column($newArray, "type"));

        return $res;
    }

    public function getTypeList(){

        $new = strtok($this->type, ",");
         $new = strtok($new, "/");
        $new = str_replace(' övrigt', '', $new);

        $query = $this->db->select("events",
        [       
            "name",
            "content",
            "link", 
            "linkContent",
            "area",
        ],
        ["AND" => ["location" => $this->place], "type[~]" => $new]);

        return $query;
    }

    public function getDiagram(){

        $query = $this->db->select("events", 
        ["type"], 
        ["location" => $this->place]);

        $res = [];
        $newArray = [];

        foreach($query as $value){
            //echo " old: ".$value["type"]."<br>";
            $new = strtok($value["type"], ",");
            //$new = strtok($new, " ");
            $new = str_replace(' övrigt', '', $new);
            //echo " new: ".$new."<br>";
            $newArray[]["type"] = $new; 
        }

        $res = array_count_values(array_column($newArray, "type"));

        $total = array_sum($res);

        foreach($res as $key => $value){
            
            $res[$key] = $this->fk->get_percentage($total, $value);
        }

        return $res;

    }

    public function getInformation() {
        
        $query = $this->db->count("events",  
	    ["location" => $this->place]);

        $query = "Antal händelser: ".$query;
        return $query;
    }

    public function getCrimeInformation() {

        $query = $this->db->select("events", 
        ["type"], 
        ["location" => $this->place]);
        
        $res = [];
        $newArray = [];

        foreach($query as $value){
            //echo " old: ".$value["type"]."<br>";
            $new = strtok($value["type"], ",");
            //$new = strtok($new, " ");
            $new = str_replace(' övrigt', '', $new);
            //echo " new: ".$new."<br>";
            $newArray[]["type"] = $new; 
        }

        $res = array_count_values(array_column($newArray, "type"));
    
        return $res;
    }

    public function getLocation() {
        $mun = $this->db->has("region_municipality", [
		"AND" => ["title" => $this->place]
        ]);

        $dis = $this->db->has("region_district", [
            "AND" => ["name" => $this->place]
        ]);

        $reg = $this->db->has("region", [
            "AND" => ["title" => $this->place]
        ]);

        if($mun){
            $query = $this->db->get("region_municipality",
                ["title", "latitude", "longitude","polygon","zoom"],
                ["AND" => ["title" => $this->place]]
            );
        }
        
        if($dis){
            $query = $this->db->get("region_district",
                ["name", "latitude", "longitude", "polygon","zoom"],
                ["AND" => ["name" => $this->place]]
            );
        }

        if($reg){
            $query = $this->db->get("region",
                ["title", "latitude", "longitude", "polygon", "zoom"],
                ["AND" => ["title" => $this->place]]
            );
        }
        
        return $query;
    }


}

?>