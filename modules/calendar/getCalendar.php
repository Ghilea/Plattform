<?php
/***************************/
/* include				   */
/***************************/
$inc = array("/res/connection.php", "/res/class/classMyValidation.php", "/res/class/classMyCalendar.php");

foreach ($inc as $value) { 
    require_once(absPath("2"). $value);
}

/***************************/
/* control absolute path   */
/***************************/
function absPath($value){ 
    return realpath(dirname(__dir__, $value)); 
}

/***************************/
/* new class               */
/***************************/
$classArray = array("myCalendar");

foreach ($classArray as $value) {
    ${$value} = new $value();
}

/***************************/
/* post data               */
/***************************/
$postData = array("id", "key");

foreach ($postData as $value) { 
    if (isset($_POST[$value])){${$value} = $_POST[$value];} 
}

/***************************/
/* array                   */
/***************************/
$daysOfWeek = ["Mån", "Tis", "Ons", "Tor", "Fre", "Lör", "Sön"];
$keyData = array("0", "1", "2");

foreach ($keyData as $value){
    if ($key == $value){
        if ($value != 0){
            $calendarData = date('Y-m-d', strtotime('+'.$value.' month', strtotime(date("Y-m-01"))));
        }else{
            $calendarData = date('Y-m-d', strtotime('+'.$value.' month', strtotime(date("Y-m-d"))));
        }
    }
} 

/***************************/
/* databas query           */
/***************************/
$query = $database->select("product_reservation",
["added"],
["AND" => ["product_id" => $id, "added[>=]" => date("Y-m-d")]]);

?>

<div class="col-full">
    <div class="wrap-col">

        <?php foreach ($daysOfWeek as $output) { ?>
			<div class='col-calendar'>
                <div class='wrap-col'>
                    <?php echo $output; ?>
                </div>
            </div>
		<?php }
           
           $myCalendar->setDate($calendarData); ?>

           <?php foreach($query as $output){
                $myCalendar->addEvent('Bokad', $output["added"]);
            } ?>
                                                
            <div class="calendar">             
                <?php echo $myCalendar->getDate(); ?>
            </div>
    </div>
</div>

<script defer src="/res/js/calendarButtonClick.js"></script>