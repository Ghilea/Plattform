<?php

class Gallery {

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
            "type" => "gallery"
        ]);
        
        return $query;
    }

    public function getGallery(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("gallery",
                [
                    "id", 
                    "image", 
                    "title", 
                    "content", 
                    "created",
                    "link",
                ],
                [
                    "id" => $id
                ]
            );

        }else{

            $count = $this->db->count("gallery");

            $query = $this->db->select("gallery",
            ["id", "image", "title", "content", "created", "link"],
            ["ORDER" => ["sticked" => "DESC", "title" => "ASC"],
            "LIMIT" => $count]);
        }

        $res = $this->fk->dynamicRow($query, $count, "gallery", "id");

        return $res;
    }

}

?>