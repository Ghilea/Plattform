<?php
header('Content-Type: application/json');

require_once "../../resources/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if($data['single']){

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

}else{

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
            [$data["getId"] =>  $data["id"]]);
    }

}

echo json_encode($query, JSON_PRETTY_PRINT);

?>