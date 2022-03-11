<?php
class Session {

    protected $sessionID;

    /***************************/
    /* Construct               */
    /***************************/
    public function __construct(){
        if(!isset($_SESSION)){
            $this->init_session();
        }
    }

    public function init_session(){
        session_start();
    }

    /***************************/
    /* session id              */
    /***************************/
   /* public function set_session_id(){
        //$this->start_session();
        $this->sessionID = session_id();
    }

    public function get_session_id(){
        return $this->sessionID;
    }

    public function session_exist($session_name){
        if(isset($_SESSION[$session_name])){
            return true;
        }else{
            return false;
        }
    }*/

    /***************************/
    /* session create          */
    /***************************/
    /*public function create_session($session_name , $is_array = false ){
        if(!isset($_SESSION[$session_name])){
            if($is_array == true){
                $_SESSION[$session_name] = array();
            }else{
                $_SESSION[$session_name] = '';
            }
        }
    }

    public function set_session( $session_name , array $data ){
        if(is_array($_SESSION[$session_name])){
            array_push($_SESSION[$session_name], $data);
        }
    }

    public function display_session($session_name){
        echo '<pre>';
        print_r($_SESSION[$session_name]);
        echo '</pre>';
    }*/

    /***************************/
    /* session close           */
    /***************************/
    public function closeSession($session_name = null){
        if(isset($session_name)){
            unset($_SESSION[$session_name]);
        }else{
            $_SESSION = array();
            unset($_SESSION);
            session_unset();
            session_destroy();
        }
    }
    
    /***************************/
    /* session data            */
    /***************************/
    public function setSessionData($session_name, $data){
        $_SESSION[$session_name] = $data;
    }
    
    public function getSessionData($session_name){
        return $_SESSION[$session_name];
    }

}

$newSession = new Session();

?>