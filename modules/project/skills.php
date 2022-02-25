<?php
header('Content-Type: application/json');

require_once "../../resources/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data["id"]) != null)
{
    $query = $database->get($data["table"],
        $data["column"],
        ["id" => $data["id"]]
    );

}else{

    $count = $database->count($data["table"]);

    $query = $database->select($data["table"],
    $data["column"],
    ["ORDER" => ["sortOrder" => "ASC", "name" => "DESC"],
    "LIMIT" => $count]);

    foreach($query as $output){
        $query = $output;
    }
}

echo json_encode($query, JSON_PRETTY_PRINT);

?>