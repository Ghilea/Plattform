<?php

class News {

    public function __construct($database = null, Functions $functions)
    {
        $this->db = $database;
        $this->fk = $functions;
    }  

    public function getNews(int $id = null)
    {

        if($id != null)
        {

            $query = $this->db->get("news",
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
        else
        {

            $count = $this->db->count("news");

            $query = $this->db->select("news",
            ["id", "image", "title", "content", "created"],
            ["ORDER" => ["sticked" => "DESC", "title" => "DESC"],
            "LIMIT" => $count]);
        }

        $res = $this->fk->dynamicNewsRow($query, $count, "news", "id");

        return $res;
    }

}

?>