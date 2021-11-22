<?php

class Project {

    public function __construct($database = null, Functions $functions)
    {
        $this->db = $database;
        $this->fk = $functions;
    }

    public function getHeader()
    {

        $query = $this->db->select("modules_content",
        [
            "name", 
            "content"
        ],
        [
            "type" => "project"
        ]);
        
        return $query;
    }

    public function getProject(int $id = null)
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

}

?>