<?php

class Login {

    protected array $errorList = [];
    protected array $errorMessage = [];

    public function __construct($database, Functions $functions)
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $this->db = $database;
        $this->fk = $functions;
    }

    public function login($email, $password)
    {
        $errorListQuery = $this->db->select("modules_content",
        ["name", "content", "image"],
        ["AND" => ["type" => "errorMessage"]]);

        foreach($errorListQuery as $output) {
            $this->errorList[$output["name"]] = $output["content"];
            $this->errorList[$output["name"]."_image"] = $output["image"];
        }

        $query = $this->db->select("account",[
            "[><]account_information" => ["account_information_id" => "id"],
            "[>]system_gender" => ["account_information.system_gender_id" => "id"],
            "[><]account_settings" => ["account_settings_id" => "id"],
            "[>]system_privilege" => ["account_settings.system_privilege_id" => "id"]
        ],[
            "account.id", "account_information.email", "password", "suspended", "system_privilege_id"
        ]);

        foreach($query as $output)
        {

            $empty = (!$this->fk->checkEmptySpace($email) || !$this->fk->checkEmptySpace($password));

            $susp = ($output["suspended"] == 1);
            
            $match = ($output["email"] != $this->fk->safe($email) || 
            (!password_verify($this->fk->safe($password), $output['password'])));

            switch(true){
                case $empty:

                    if(!$this->fk->checkEmptySpace($email)){
                        $this->errorMessage["errorEmail"] = $this->errorList["emptyField"];
                        
                        $this->errorMessage["errorEmail_image"] = $this->errorList["emptyField_image"];
                    }
                    
                    if(!$this->fk->checkEmptySpace($password)){
                        $this->errorMessage["errorPassword"] = $this->errorList["emptyField"];

                        $this->errorMessage["errorPassword_image"] = $this->errorList["emptyField_image"];
                    }

                    $result = $this->errorMessage;
                break;
                case $susp:
                    $this->errorMessage["errorAll"] = $this->errorList["accountSuspended"];

                    $this->errorMessage["errorAll_image"] = $this->errorList["accountSuspended_image"];

                    $result = $this->errorMessage;
                break;
                case $match:
                    $this->errorMessage["errorAll"] = $this->errorList["fieldMatch"];

                    $this->errorMessage["errorAll_image"] = $this->errorList["fieldMatch_image"];

                    $result = $this->errorMessage;
                break;
                default:
                    $result = null;

                    //$this->id["id"] = $output["id"];
                    //$this->privilege = $output["system_privilege_id"];

                    //add login status
                    $this->db->update("account_settings",
                    ["status" => 1],["id" => $output["id"]]);

                    //add sessions
                    $this->setSessionData("id", $output["id"]);
                    $this->setSessionData("privilege", $output["system_privilege_id"]);
                    
                    header("Location: /index.php");
                break;
            }

        }

        return $result;
    }

    public function logout($id){
        $this->db->update("account_settings",
        ["status" => null],["id" => $id]);

        $this->closeSession();

        header("Location: /index.php"); exit;
    }

    protected function closeSession($session_name = null){
        if(isset($session_name)){
            unset($_SESSION[$session_name]);
        }else{
            session_destroy();
        }
    }

    protected function setSessionData($session_name, $data){
        $_SESSION[$session_name] = $data;
    }

} ?>