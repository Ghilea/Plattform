<?php
class BBCode {
    
    /***************************/
    /* bbCodeMenu	           */
    /***************************/
    function bbCodeMenu(){
        
        foreach($buttonArray as $output){ 		        
            
            $this->button .= '
                <div class="bbCode" id="'.$output["css"].'" title="'.$output["title"].'">
                    <img src="'.$output["link"].'" alt="">
                </div>';
        }

        return $this->button;
    
    }  

} ?>