<?php
header('Content-Type: application/json');

require_once "../../php/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['and'])){
    $query = $database->select($data["table"],
        $data["column"],
        ["AND" => [$data["and"]["set"] => $data["and"]["value"], "override" => null],
        "ORDER" => ["sortOrder" => "ASC"]]
    );
}

if(isset($data['single'])){

    if(isset($data["id"]))
    {
        $query = $database->get($data["table"],
            $data["column"],
            ["id" => $data["id"]]
        );
    }else{
        $query = $database->select($data["table"],
            $data["column"],
            ["ORDER" => [$data["order"] => "ASC"]]);
    }   

}

if(isset($data["multi"])){

    if(isset($data['table2'])){
        $query = $database->select($data["table"],
            [$data['table2']['table'] => [$data['table2']['id'] => "id"]],
            $data["column"],
            [$data["getId"] =>  $data["id"]],
            ["ORDER" => [$data["order"]["column"] => $data["order"]["direction"]]]
        );
    }else{
        $query = $database->select($data["table"],
            $data["column"],
            [isset($data["getId"]) =>  isset($data["id"])]);
    }

}

echo json_encode($query, JSON_PRETTY_PRINT);

?>