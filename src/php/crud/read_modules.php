<?php
header('Content-Type: application/json');

require_once "../../php/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$query = $database->select("modules_content",
    ["[><]modules" => ["modules_id" => "id"]],
    ["modules_content.content", 'modules_content.name'],
    [
        "AND" => ["moduleOn" => 1, "type" => $data["type"], "active" => 1],
        "ORDER" => ["sortOrder" => "ASC"]
    ]
);

echo json_encode($query, JSON_PRETTY_PRINT);

?>