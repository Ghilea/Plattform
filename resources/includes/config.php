<?php

class Config {

	public array $settings = [];

	public function __construct($database){
        $this->db = $database;
	}
	
	public function ActivateModule(string $page = null){

		$query = $this->db->select("modules_content",
			["[><]modules" => ["modules_id" => "id"]],
			[ 
				"link",
			],
			[
				"AND" => ["moduleOn" => 1, "type" => $page, "link[!]" => null, "modules_content.active" => 1],
				"ORDER" => ["sortOrder" => "ASC"]
			]
		);

		return $query;
	}

	public function ActivateSideMenu(string $page = null, string $class = null){

		$query = $this->db->select("modules_content",
			[ 
				"link",
			],
			[
				"AND" => ["type" => $page, "class" => $class, "link[!]" => null]
			]
		);

		return $query;
	}

	public function getFooter(){

		$i = 0;
		$result = null;

		$checkQuery = $this->db->has("modules_content", [
				"AND" => ["type" => "footContent", "active" => 1]
			]
		);

		if($checkQuery){
			
			$query = $this->db->select("modules",
			["[>]modules_content" => 
			["id" => "modules_id"]],
				[
					"modules_content.id",
					"modules_content.name"
				],
				[
					"AND" => ["type" => "footContent", "moduleOn" => 1, "modules_content.active" => 1	],
					"ORDER" => ["modules_content.sortOrder" => "ASC"]
				]
			);

			foreach($query as $output){
				$query2 = $this->db->select("modules_content_sub",
					[
						"[><]modules_content" => ["modules_content_sub.modules_content_id" => "id"]
					],
					[ 
						"modules_content_sub.link",
						"modules_content_sub.name"
					],
					[
						"AND" => ["type" => "footContent", "modules_content_id" => $output["id"]],
						"ORDER" => ["modules_content.sortOrder" => "ASC", "modules_content_sub.sortOrder" => "ASC"]
					]
				);

				$query[$i]["sub"] = $query2;

				$i++;
			}

			$result = $query;

		}else{
			$result = $checkQuery;
		}
		

		return $result;
	}

	public function GetMenu(){
		$array = [];

		$query = $this->db->select("modules",
			[
				"[><]modules_content" => ["id" => "modules_id"]
			],
			[
				"modules_content.content",
				"modules_content.name", 
				"modules_content.link",
				"modules_content.image",
				"modules_content.class",
				"modules_content.target_id",
				"modules.moduleName"
			],
			[
				"AND" => ["modules.moduleOn" => 1, "type" => "menu", "modules_content.active" => 1], 
				"ORDER" => ["modules_content.sortOrder" => "ASC"]
			]
		);

		foreach($query as $output){
			switch($output["moduleName"]){
				case "login":
					if (empty($_SESSION["id"])){
						$array[] = ["name" => $output["name"], "link" => $output["link"], "class" => $output["class"], "target_id" => $output["target_id"], "image" => $output["image"]];
					}
					break;
				case "account":
					if (isset($_SESSION["id"])){
						$array[] = ["id" => str_replace("#", "", $output["content"]),"name" => $output["name"], "link" => "javascript:void(0);", "class" => $output["class"], "target_id" => $output["target_id"], "image" => $output["image"]];
					}
					break;
				default:
					$array[] = ["name" => $output["name"], "link" => $output["link"], "class" => $output["class"], "target_id" => $output["target_id"], "image" => $output["image"]];
					break;
			}
		}

		return $array;
	}

	public function GetConfig(string $type){

		$query = $this->db->select("config",
			["name", "content", "image", "link"],
			["AND" => ["type" => $type, "active" => 1],
			"ORDER" => ["sort" => "ASC"]]
		);
			
		return $query;
		
	}

	public function GetSocialMedia(){
		$array = [];

		$query = $this->db->select("config",
			[
				"name", 
				"content",
				"image", 
				"link"
			],
			["AND" => ["type" => "socialmedia"]]
		);
			
		foreach($query as $output){
			$array[] = [
				"name" => $output["name"], "content" => $output["content"], "image" => $output["image"],
				"link" => $output["link"]];
		}

		return $array;

	}

	public function GetSettingsBtn(){
		$query = $this->db->select("modules",
			[
				"[><]modules_content" => ["id" => "modules_id"]
			],
			[
				"modules_content.content",
				"modules_content.name", 
				"modules_content.link",
				"modules_content.image",
				"modules_content.class",
				"modules_content.target_id",
				"modules.moduleName",
				"modules.moduleOn"
			],
			[
				"AND" => [
					"moduleOn" => 1, "moduleName" => "settings",
				], 
				
				"ORDER" => ["modules_content.sortOrder" => "ASC"]
			]
		);

		return $query;
	}
}

?>