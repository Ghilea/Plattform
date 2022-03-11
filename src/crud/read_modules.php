<?php
header('Content-Type: application/json');

require_once "../../resources/includes/connection.php";

$data = json_decode(file_get_contents("php://input"), true);

$query = $database->select("modules_content",
    ["[><]modules" => ["modules_id" => "id"]],
    ["modules_content.content", 'modules_content.name', 'modules_content.link'],
    [
        "AND" => ["moduleOn" => 1, "type" => 'index', "link[!]" => null, "modules_content.active" => 1],
        "ORDER" => ["sortOrder" => "ASC"]
    ]
);

echo json_encode($query, JSON_PRETTY_PRINT);

?>