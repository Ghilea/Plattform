<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/public/php/lib/medoo/medoo.php");

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
	]
);

spl_autoload_register('autoloadclass');

function autoloadclass($className){

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
		]
	);

	$sql = $database->Select("config", 
	["name", "link"],
	["AND" => ["type" => "class"]]);

	foreach($sql as $output){
		if($className === $output["name"]) {
			include($output["link"]);
		}
	}
	
}
?>