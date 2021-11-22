<?php 
class Date {

    public $ageCalc;
    public $ageNum;
    private $reDate;

    /***************************/
    /* rewrite date            */
    /***************************/
    function rewriteDate($value, $value2){
        
        date_default_timezone_set("Europe/Stockholm");
        setlocale(LC_ALL, 'sv_SE', 'swedish');
    
        $this->reDate = utf8_encode(strftime($value, strtotime($value2)));
        
        return $this->reDate;

    }

    /***************************/
    /* ageNum       		   */
    /***************************/
    function setAgeNum($value){

        $year = substr($value, 0, 4);
        $month = substr($value, 4, 2);
        $day = substr($value, 6, 2);
        $civ = substr($value, 8, 4);
        
        $this->ageNum = $year.".".$month.".".$day."-".$civ;

    }
    
    function getAgeNum(){
    
        return $this->ageNum;

    }

    /***************************/
    /* ageCal	    		   */
    /***************************/
    function setAgeCalc($value){
    
        $thisYear = date("Ymd");
        $birth = substr($value, 0, 8);
        
        $age = $thisYear - $birth;
        
        $this->ageCalc = substr($age, 0, 2);
    }
    
    function getAgeCalc(){
        
        return $this->ageCalc;
 
    }

} ?>