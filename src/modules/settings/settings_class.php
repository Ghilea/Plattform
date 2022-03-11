<?php

class Settings {

    public function __construct($database = null, Functions $functions)
    {
        $this->db = $database;
        $this->fk = $functions;
    }

    public function getHeader()
    {

        $query = $this->db->get("modules_content",
        ["name"],
        ["type" => "settings"]);

        return $query["name"];
    }

    public function getMenuButtons()
    {

        $query = $this->db->select("modules_content_sub",
        ["name", "class", "link"],
        ["modules_content_id" => "69"]);

        return $query;
    }

    public function getModules(int $id = null) {

        if($id != null)
        {

            $query = $this->db->get("modules",
                [
                    "id", 
                    "moduleOn", 
                    "moduleName", 
                ],
                ["id" => $id, "override" => 0]
            );

        }else{

            $count = $this->db->count("modules");

            $query = $this->db->select("modules",
            ["id", "moduleOn", "moduleName"],
            ["override" => 0],
            ["ORDER" => ["moduleName" => "ASC"],
            "LIMIT" => $count]);
        }

        $res = $this->fk->dynamicRow($query, $count, "presentation", "id");

        return $res;
    }

    public function getConfigs(int $id = null) {

        if($id != null)
        {

            $query = $this->db->get("config",
                [
                    "id", 
                    "moduleOn", 
                    "moduleName", 
                ],
                ["id" => $id, "override" => 0]
            );

        }else{

            $count = $this->db->count("config");

            $query = $this->db->select("config",
            ["id", "type", "active", "name", "content", "image", "link"],
            ["ORDER" => ["type" => "ASC", "name" => "ASC", "active" => "ASC"],
            "LIMIT" => $count]);
        }

        //$res = $this->fk->dynamicRow($query, $count, "presentation", "id");

        return $query;
    }

    public function getSkills(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("project_skills",
                [
                    "name", 
                    "link", 
                    "class"
                ],
                [
                    "id" => $id
                ]
            );

        }else{

            $count = $this->db->count("project_skills");

            $query = $this->db->select("project_skills",
            ["link", "name", "class"],
            ["ORDER" => ["sortOrder" => "ASC", "name" => "DESC"],
            "LIMIT" => $count]);

        }

        return $query;
        
    }


    public function getSettings(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("project",
                [
                    "id", 
                    "image", 
                    "title", 
                    "content", 
                    "created",
                    "showBtn",
                    "link",
                    "link2"
                ],
                [
                    "id" => $id
                ]
            );

        }else{

            $count = $this->db->count("project");

            $query = $this->db->select("project",
            ["id", "image", "title", "content", "created", "showBtn", "link", "link2"],
            ["ORDER" => ["sticked" => "DESC", "title" => "ASC"],
            "LIMIT" => $count]);
        }

        $res = $this->fk->dynamicRow($query, $count, "presentation", "id");

        return $res;
    }

}

?>