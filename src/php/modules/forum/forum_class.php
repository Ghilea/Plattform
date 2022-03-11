<?php

class Forum {

    protected object $db;
    protected Functions $functions;
    public int $privilege;
    protected string $type;
    public int $id;

    public array $headerTitle = [];
    public array $headerTitle2 = [];
    public array $add = [];
    public array $edit = [];
    public array $delete = [];
    public string $link;

    public array $nav = [];

    protected int $pagingPerPage = 15;
    protected int $pagingPageNumber;
    protected int $pagingPageStart;

    public function __construct(object $database, Functions $functions)
    {
        
        $this->db = $database;
        $this->fk = $functions;

        if (isset($_SESSION["id"])) 
        {
            $this->privilege = $_SESSION['privilege'];
        }
        else
        {
            $this->privilege = 1;
        }

        if(isset($_GET["id"])){
            $this->id = intval($_GET["id"]);
        }else{
            $this->id = 1;
        }

        if(isset($_GET["page"])){
            $this->pagingPageNumber = intval($_GET["page"]);
        }else{
            $this->pagingPageNumber = 1;
        }

        $calc = $this->pagingPerPage * $this->pagingPageNumber;
        $this->pagingPageStart = $calc - $this->pagingPerPage;
    }

    public function getForumPart(string $type){

        $this->type = $type;

        $query = $this->db->select("modules_content",
        [
            "id",
            "name", 
            "link", 
            "image", 
            "privilege_id",
            "class"
        ],[
            "AND" => ["type" => $this->type]]);

        $this->single($query);

        switch($this->type){
            case "forum":
                $result = $this->forum();
            break;
            case "topic":
                $result = $this->topic();
            break;
            case "post":
                $result = $this->post();
            break;
        }

        return $result;
    }

    protected function forum()
    {
        $i = 0;

        $query = $this->db->select("forum",[
            "[><]system_color" => ["forum.system_color_id" => "id"],
            "[><]system_privilege" => ["forum.system_privilege_id" => "id"]
        ],[
            "forum.id", 
            "forum.title", 
            "forum.content", 
            "system_color.color"
        ],[
            "AND" => ["forum.system_privilege_id[<=]" => $this->privilege],
            "ORDER" => ["forum.id" => "ASC"]]);

        foreach($query as $output)
        {
            $countThread = $this->db->count("forum_thread", ["forum_id" => $output["id"]]);

            if($countThread != null)
            {
                $query[$i]["threadCount"] = $countThread;
            }else{
                $query[$i]["threadCount"] = 0;
            }

            $i++;
        }

        return $query;
    }

    protected function single($query){
        foreach($query as $output)
        {
            switch($output["class"]){
                case "headerTitle":
                    $this->headerTitle["name"] = $output["name"];
                    $this->headerTitle["link"] = $output["link"];
                break;
                case "headerTitle2":
                    $this->headerTitle2["link"] = $output["link"];
                break;
                case "add":
                    $this->add["name"] = $output["name"];
                    $this->add["link"] = $output["link"];
                    $this->add["image"] = $output["image"];
                    $this->add["privilege"] = $output["privilege_id"];
                break;
                case "edit":
                    $this->edit["name"] = $output["name"];
                    $this->edit["link"] = $output["link"];
                    $this->edit["image"] = $output["image"];
                    $this->edit["privilege"] = $output["privilege_id"];
                break;
                case "delete":
                    $this->delete["name"] = $output["name"];
                    $this->delete["link"] = $output["link"];
                    $this->delete["image"] = $output["image"];
                    $this->delete["privilege"] = $output["privilege_id"];
                break;
                case "topicLink":
                    $this->link = $output["link"];
                break;
                case "postLink":
                    $this->link = $output["link"];
                break;
            }
            
        }
    }

    protected function topic()
    {
        $i = 0;

        $query = $this->db->select("forum_thread",[
            "[><]forum" => ["forum_thread.forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"]
        ],[
            "forum_post.id(post_id)",
            "forum_thread.id(thread_id)",
            "forum_thread.forum_id",
            "forum_post.title",
            "forum_post_chain"
        ],[
            "AND" =>[
                "forum_thread.forum_id" => $this->id,
                "forum_post.creator" => 1
            ], 
            "ORDER" => ["forum_post.created" => "DESC"],
            "LIMIT" => [$this->pagingPageStart, $this->pagingPerPage]]);

        $queryForum = $this->db->get("forum",["title"],["id" => $this->id]);

        $this->nav["title"] = $queryForum["title"];

        foreach($query as $output)
        {

            $countPost = $this->db->count("forum_post", ["forum_thread_id" => $output["thread_id"]]);

            if($countPost != null)
            {
                $query[$i]["postCount"] = $countPost-1;
            }else{
                $query[$i]["postCount"] = 0;
            }

            $i++;

        }

        return $query;

    }

    protected function post()
    {
        $i = 0;

        $query = $this->db->select("forum_thread",[
            "[><]forum" => ["forum_thread.forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"],
            "[><]account" => ["forum_thread.account_id" => "id"],
            "[><]account_information" => ["account.account_information_id" => "id"],
            "[><]account_settings" => ["account.account_settings_id" => "id"]
        ],[
            "forum_thread.id",
            "forum.id(forum_id)",
            "forum_post.id(post_id)",
            "forum_post.title", 
            "forum_post.content",
            "forum_post.created",
            "forum_post.locked",
            "account_information.firstname",
            "account_information.lastname",
            "account_settings.profile_image",
            "account.image",
            "forum_thread.account_id"
        ],["AND" => ["forum_post.forum_thread_id" => $this->id], 
        "ORDER" => ["forum_post.created" => "ASC"], 
        "LIMIT" => [$this->pagingPageStart, $this->pagingPerPage]]);

        $queryForum = $this->db->select("forum_thread",[
            "[><]forum" => ["forum_id" => "id"],
            "[><]forum_post" => ["id" => "forum_thread_id"]
        ],[
            "forum.title(title)",
            "forum_post.title(threadTitle)",
            "forum_id"
        ],["AND" =>["forum_thread.id" => $this->id]]);

        foreach($queryForum as $output)
        {
            $this->nav["forum_id"] = $output["forum_id"];
            $this->nav["title"] = $output["title"];
            $this->nav["threadTitle"] = $output["threadTitle"];
        }

        foreach($query as $output)
        {

            $countPost = $this->db->count("forum_post", ["forum_thread_id" => $this->id]);

            if($countPost != null)
            {
                $query[$i]["postCount"] = $countPost-1;
            }else{
                $query[$i]["postCount"] = 0;
            }

            $i++;

        }

        return $query;

    }

    public function createForum(string $table, array $value){
        
        /*
            "title" => $title, 
            "content" => $text, 
            "system_privilege_id" => $privilege, "system_color_id" =>  $color
        */
        $thia->db->insert($table,
        [$valueInsert]);

        $headerMessage = "Location: /pages/forum.php";
		header($headerMessage); 
    }

}

?>