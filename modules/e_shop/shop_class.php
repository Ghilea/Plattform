<?php

class Shop {

    private $db;
    private $fk;

    public $myPaging = [];

    public function __construct($database = null, Functions $functions = null){
        $this->db = $database;
        $this->fk = $functions;
    }

    public function productOrder(){

        $count = $this->db->count("product_order", [
            "account_id" => 1
        ]);

        if ($count <= 0) {
            $result = 0;
        }else{
            $result = $count;

            $query = $this->db->select("product_order",
                [
                    "account_id",
                    "product_id", 
                    "order_id",
                    "price",
                    "quantity",
                    "date"

                ],
                [
                    "account_id" => 1
                ]
            );
        }
        
        return $result;
        
    }

    public function getShopHeader(){

        $query = $this->db->select("modules_content",
            [
                "name", 
                "content",
            ],
            [
                "type" => "shop"
            ]
        );

        return $query;
        
    }

    public function getProduct(int $id = null, int $perPage = 50){

        //$id = $this->fk->GetId("product", "id");

        if($id != null){

            $query = $this->db->get("product",
                [
                    "id", 
                    "image", 
                    "title", 
                    "content", 
                    "price",
                    "quantity_in_stock",
                    "quantity_on_order",
                ],
                [
                    "id" => $id
                ]
            );

            return $query;
        }else{

            if(isset($_GET["page"])){
                $page = intval($_GET["page"]);
            }else{
                $page = 1;
            }

            if(isset($_GET["category"])){
                $category = intval($_GET["category"]);
            }
            
            $calc = $perPage * $page;
            $start = $calc - $perPage;

            if(isset($category)){
                $queryProduct = $this->db->select("product",[
                "[><]account" => ["account_id" => "id"],
                "[><]account_information" => ["account.account_information_id" => "id"],
                "[><]account_settings" => ["account.account_settings_id" => "id"]
            ],[
                "product.id",
                "product.title",
                "product.content",
                "product.price",
                "product.image",
                "product.quantity_in_stock",
                "product.quantity_on_order",
                "account_information.firstname",
                "account_information.lastname",
                "account_information.phoneNumber",
                "account_information.email"
            ],[
                "AND" => ["product_category" => $category],
                "ORDER" => ["product.title" => "ASC"],
                "LIMIT" => [$start, $perPage]
            ]);
            }else{
                $queryProduct = $this->db->select("product",[
                    "[><]account" => ["account_id" => "id"],
                    "[><]account_information" => ["account.account_information_id" => "id"],
                    "[><]account_settings" => ["account.account_settings_id" => "id"]
                ],[
                    "product.id",
                    "product.title",
                    "product.content",
                    "product.price",
                    "product.image",
                    "product.quantity_in_stock",
                    "product.quantity_on_order",
                    "account_information.firstname",
                    "account_information.lastname",
                    "account_information.phoneNumber",
                    "account_information.email"
                ],[
                    "ORDER" => ["product.title" => "ASC"],
                    "LIMIT" => [$start, $perPage]
                ]);
            }
            


            return $queryProduct;   
        }     
        
    }

    public function productCategory(){

        $id = $this->fk->GetId("product_category", "id");

        if($id != null){

            $query = $this->db->get("product_category",
                [
                    "id",  
                    "title", 
                    "link", 
                ],
                [
                    "id" => $id
                ]
            );

            return $query;
        }else{

            $queryProduct = $this->db->select("product_category",[
                "product_category.id",
                "product_category.title",
                "product_category.link",
            ],[
                "ORDER" => ["product_category.title" => "ASC"]]);

            return $queryProduct;   
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