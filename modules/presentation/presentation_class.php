<?php

class Presentation {

    public function __construct($database = null, Functions $functions)
    {
        $this->db = $database;
        $this->fk = $functions;
    }  

    public function getAboutMe(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("presentation",
                [
                    "id", 
                    "image", 
                    "title", 
                    "content", 
                    "created"
                ],
                [
                    "id" => $id
                ]
            );

        }
        /*else
        {

            $count = $this->db->count("presentation");

            $query = $this->db->select("presentation",
            ["id", "image", "title", "content", "created"],
            ["ORDER" => ["sticked" => "DESC", "title" => "DESC"],
            "LIMIT" => $count]);
        }

        $res = $this->fk->dynamicPresentationRow($query, $count, "presentation", "id");
*/
        return $res;
    }

    public function getMyHobby(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("presentation_content_sub",
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

            $count = $this->db->count("presentation_content_sub");

            $query = $this->db->select("presentation_content_sub",
            ["link", "name", "class"],
            ["ORDER" => ["sortOrder" => "DESC", "name" => "DESC"],
            "LIMIT" => $count]);

        }

        return $query;
        
    }

}

?>