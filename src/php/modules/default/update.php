<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/resources/lib/medoo/medoo.php");

use Medoo\Medoo;
$database = new Medoo(
[
    // required
    'database_type' => 'mysql',
    'database_name' => 'platform',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',

    // [optional]
    'charset' => 'utf8',
    'port' => 3306,

    // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

    // [optional] Medoo will execute those commands after connected to the database for initialization
    'command' => [
        'SET SQL_MODE=ANSI_QUOTES'
    ]
]);

$postData = ["table", "column", "content", "id"];

foreach($postData as $value){
    if(isset($_POST[$value])){
        ${$value} = $_POST[$value];
    }else{
        ${$value} = null;
    }
}

$database->update($table, 
    [$column => $content], 
    ["id" => $id]
);

$data = $database->get($table, 
    [$column], 
    ["id" => $id]
);    

echo json_encode($data);

?>
