<?php
header('Content-Type: application/json');

require_once "../../resources/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if($data['single']){

    if(isset($data["id"]) > 0)
    {
        $query = $database->get($data["table"],
            $data["column"],
            ["id" => $data["id"]]
        );
    }else{
        $query = $database->select($data["table"],
            $data["column"],
            ["ORDER" => ["sortOrder" => "ASC", "name" => "DESC"]]);
    }   

}else{

    if(isset($data['table2'])){
        $query = $database->select($data["table"],
            ["[<]project_skills" => ["project_skills_id" => "id"]],
            //[$data["table2"] => ["project_skills_id" => "id"]],
            $data["column"],
            ["project_id" =>  $data["id"]]);
    }else{
        $query = $database->select($data["table"],
            $data["column"],
            ["project_id" =>  $data["id"]]);
    }

}

echo json_encode($query, JSON_PRETTY_PRINT);

?>