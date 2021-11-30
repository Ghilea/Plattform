<?php

class Project {

    public function __construct($database, Functions $functions)
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
            [
                "[><]project_images" => ["project.id" => "project_id"],
                "[<]project_skills" => ["project_images.project_skills_id" => "id"]],
            [
                "project.id", 
                "project.image", 
                "project.title", 
                "project.content", 
                "project.created",
                "project.showBtn",
                "project.link",
                "project.link2",
                
            ],
            ["ORDER" => ["project.sticked" => "DESC", "project.title" => "ASC"],
            "LIMIT" => $count]);

            var_dump($query);

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