<?php

class Education {

    public function __construct($database = null, Functions $functions = null){
        $this->db = $database;
        $this->fk = $functions;
    }  

    public function getEducation(){

        $id = $this->fk->GetId("education", "id");

        if($id != null){

            $query = $this->db->get("education",
                [
                    "id", 
                    "image", 
                    "title", 
                    "content", 
                    "difficulty"
                ],
                [
                    "id" => $id
                ]
            );

            return $query;
        }else{

            $count = $this->db->count("education");

            $query = $this->db->select("education",
            ["id", "image", "title", "content", "difficulty"],
            ["ORDER" => ["sticked" => "DESC", "title" => "ASC"],
            "LIMIT" => $count]);
            
            $res = $this->fk->dynamicRow($query, $count, "education_task", "education_id");
            return $res;   
        }     
        
    }

    public function getEducationTask(){

        $id = $this->fk->GetId("education_task", "education_id");

        $count = $this->db->count("education_task", [
	    "education_id" => $id
        ]);

        $query = $this->db->select("education_task",
        ["id", "title", "content"],
        ["AND" => ["education_id" => $id],
        "ORDER" => ["sticked" => "DESC", "title" => "ASC"],
        "LIMIT" => $count]);

        return $query;
    }

    public function getEducationTaskView(){

        $queryArray = [];

        $id = $this->fk->GetId("education_task", "id");

        //task
        $queryArray["view"] = $this->db->get("education_task",
        ["[><]education" => ["education_task.education_id" => "id"]],
        [
            "education.id",
            "education.title(education_title)",
            "education_task.title", 
            "education_task.content",  
            "education.image"
        ],
        ["AND" => ["education_task.id" => $id]]);
         
        //video
        $queryArray["video"] = $this->db->select("education_video",[
            "title", "link"
        ],["AND" => ["education_task_id" => $id, "link[!]" => null],
            "ORDER" => ["education_video.sticked" => "DESC", "education_video.title" => "ASC"]]);

        //training
        $queryArray["task"] = $this->db->select("education_training",[
            "title",
        ],["AND" => ["education_task_id" => $id]]);

        return $queryArray;
    }

}

?>