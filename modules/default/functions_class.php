<?php

class Functions {

    private $db;
    private $pageSite;
	private $table;
	private $value;
	private $id;
	private $perPage;
	private $page;

    public function __construct($database = null){
        $this->db = $database;
    }  

    public function GetId(string $table, string $column) {
        
        if(isset($_GET["id"]))
        {
            $id = $_GET["id"];
    
            //take only int and check if the int exist in database
            if (!$this->db->has($table, ["AND" => [$column => $id]]) 
            || filter_var($id, FILTER_VALIDATE_INT) === false) {
                header("Location: /index.php"); exit;
            }

        }else{
            $id = null;
        }

        return $id;
    }

    public function post(array $postData) {
        
        foreach($postData as $value){
            if(isset($_POST[$value])){
                ${$value} = $_POST[$value];
            }else{
                ${$value} = null;
            }
        }

    }

    public function get(array $postData) {
        
        foreach($getData as $value){
            if(isset($_GET[$value])){
                ${$value} = intval($_GET[$value]);
            }else{
                ${$value} = null;
            }
        }

    }

    public function getLinkName(){
        $url = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $result = substr( $url, 0, strrpos( $url, "."));

        return $result;
    }

    public function dynamicRow($query, $count, $table, $tableColumn){
        $i=0;
        $columnLimit = 3;
        $column = 0;
        $row = 0;
        $color = 1;
        $row2Width = "";
        $row3Width = "";

        for($x = 0; $x < $count; $x++){

           if($column == $columnLimit){
                $column = 0;	
                $row++;
            }

            $column++;
        }

        foreach($query as $output)
        {
            
            if($i >= $count-$column)
            {
            
                switch($column)
                {
                    case 1:
                        $row2Width = "col-6-12m";
                        $row3Width = "col-full";
                    break;
                    case 2:
                        $row2Width = "col-6-12m";
                        $row3Width = "col-6-12";
                    break;
                    case 3:
                        if($i == ($count-1)){
                            $row2Width = "autoWidthm";
                            $row3Width = "col-4-12";
                        }
                    break;
                }
            }else{
                $row2Width = "col-6-12m";             
                $row3Width = "col-4-12";
            }

            if($color == 5){
                $color = 1;
            }

            $query[$i]["boxColor"] = "boxColor".$color;
            $rowClass = $row2Width. ' ' .$row3Width;
            $query[$i]["rowClass"] = $rowClass;

            //hide or not
            $check = $this->db->count($table,
            [$tableColumn => $output["id"]]);
            
            if($check <= 0){
                $hide = "hide";
            }else{
                $hide = "";
            }
            
            $query[$i]["hide"] = $hide;
            
            $color++;
            $i++;
        }

        return $query;

    }

    public function dynamicNewsRow($query, $count, $table, $tableColumn){
        $i=0;
        $columnLimit = 1;
        $column = 0;
        $row = 0;
        $color = 1;
        $row2Width = "";
        $row3Width = "";

        for($x = 0; $x < $count; $x++){

           if($column == $columnLimit){
                $column = 0;	
                $row++;
            }

            $column++;
        }

        foreach($query as $output)
        {
            
            if($i >= $count-$column)
            {
            
                switch($column)
                {
                    case 1:
                        $row2Width = "col-6-12m";
                        $row3Width = "col-full";
                    break;
                    case 2:
                        $row2Width = "col-6-12m";
                        $row3Width = "col-full";
                    break;
                    case 3:
                        if($i == ($count-1)){
                            $row2Width = "autoWidthm";
                            $row3Width = "col-4-12";
                        }
                    break;
                }
            }else{
                $row2Width = "col-6-12m";             
                $row3Width = "col-full";
            }

            if($color == 5){
                $color = 1;
            }

            $query[$i]["boxColor"] = "boxColor".$color;
            $rowClass = $row2Width. ' ' .$row3Width;
            $query[$i]["rowClass"] = $rowClass;

            //hide or not
            $check = $this->db->count($table,
            [$tableColumn => $output["id"]]);
            
            if($check <= 0){
                $hide = "hide";
            }else{
                $hide = "";
            }
            
            $query[$i]["hide"] = $hide;
            
            $color++;
            $i++;
        }

        return $query;

    }

    public function ellipsis($text, $maxLength = 100){
        
        $bbArray = [
            "/\[b\](.*?)\[\/b\]/is" => "<b>$1</b>",
            "/\[i\](.*?)\[\/i\]/is" => "<i>$1</i>",
            "/\[u\](.*?)\[\/u\]/is" => "<u>$1</u>" ,
            "/\[s\](.*?)\[\/s\]/is" => "<s>$1</s>",
            "/\[left\](.*?)\[\/left\]/is" => "<p class='txtLeft'>$1</p>",
            "/\[center\](.*?)\[\/center\]/is" => "<p class='txtCenter'>$1</p>",
            "/\[right\](.*?)\[\/right\]/is" => "<p class='txtRight'>$1</p>",
            "/\[img\](.*?)\[\/img\]/is" => "<img class='imageBBCode' src='$1' alt='$1'>",
            "/\[url=(.*?)\](.*?)\[\/url\]/is" => "<a href='$1'>$2</a>" 
        ];
        
        $newText = nl2br(preg_replace(array_keys($bbArray), array_values($bbArray), strip_tags(htmlentities($text))));

        if (strlen($newText) > $maxLength)
        {
            $lastPos = ($maxLength - 3) - strlen($newText);

            $newText = mb_substr($text, 0, strrpos($newText, ' ', $lastPos)) . '...';
        }

        return $newText;
    }

    function checkEmptySpace($value){

        $value = trim($value);

        return (isset($value) && strlen($value)); 
    }

    function safe($value){

        $value = htmlentities(strip_tags(trim($value)));
        
        return $value;
    }

    public function setPaging(string $pageSite, string $table, string $value, int $id = null, int $perPage, int $page){
		$this->pageSite = $pageSite;
		$this->table = $table;
		$this->value = $value;
		$this->id = $id;
		$this->perPage = $perPage;
        $this->page = $page;
    }
    
    public function getPaging(string $table, int $perPage = 50, string $value = "id", int $id = null){

        $pageSite = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if(isset($_GET["page"])){
            $page = intval($_GET["page"]);
        }else{
            $page = 1;
        }

        if(isset($_GET["category"])){
            $category = htmlspecialchars($_GET["category"]);
        }

		//if exist
		if($id <= -1  && $this->db->has($table,[
            "AND" =>[$value => $id]
		])) {
            //count
			$countThread = $this->db->count($table, [$value => $id]);
        }else{
            
            if(isset($_GET["category"])){
                //count
			    $countThread = $this->db->count($table,[
                    "product_category" => $category
                ]);
            }else{
                //count
			    $countThread = $this->db->count($table);
            }
            
        }
			        
		$totalPages = ceil($countThread / $perPage);
            
		//prev button
		if($page <=1 ){ 
			$backBtn = "<div class='pagingEnd'>Föregående</div>"; 
		}else{

            $j = $page - 1;

            if(isset($id)){
                $link = "id=".$id."&page=".$j."";
            }else if(isset($category)){
                $link = "category=".$category."&page=".$j."";
            }else{
                $link = "page=".$j."";
            }

    		$backBtn = "<a href='$pageSite?$link'><div class='paging'>< Föregående</div></a>";
		}
	
        //number button
        $statusBtn = [];

		for($i=1; $i <= $totalPages; $i++){

            if(isset($id)){
                $link = "id=".$id."&page=".$i."";
            }else if(isset($category)){
                $link = "category=".$category."&page=".$i."";
            }else{
                $link = "page=".$i."";
            }

            if($i <> $page){
				array_push($statusBtn, "<a href='$pageSite?$link'><div class='paging'>$i</div></a>");
			}else{
				array_push($statusBtn, "<div class='pagingCurrent'>$i</div>");
			}
		}
	
		//next button
		if($page == $totalPages){
			$forwardBtn = "<div class='pagingEnd'>Nästa</div>";
		}else{
        
            $j = $page + 1;
                    
            if(isset($id)){
                $link = "id=".$id."&page=".$j."";
            }else if(isset($category)){
                $link = "category=".$category."&page=".$j."";
            }else{
                $link = "page=".$j."";
            }

			$forwardBtn = "<a href='$pageSite?$link'><div class='paging'>Nästa ></div></a>";
		}
        
        return $result = [["backBtn" => $backBtn, "statusBtn" => $statusBtn, "forwardBtn" => $forwardBtn]];
    }

    public function rewriteDate($date, $format = '%d %b %Y'){

        date_default_timezone_set("Europe/Stockholm");
        setlocale(LC_ALL, 'sv_SE', 'swedish');
    
        $newDateFormat = utf8_encode(strftime($format, strtotime($date)));
        
        return $newDateFormat;

    }

    public function get_percentage($total, $number)
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }

    public function headModuleText(){
		$array = [];

		$query = $this->db->select("modules_content_sub",
			[
				"name", 
				"class",
                "link"
			],
            ["AND" => ["modules_content_id" => 14, "override" => null],
            "ORDER" => ["sortOrder" => "ASC"]]
		);
		
		return $query;
		
	}

    public function headRightModule(){

        $query = $this->db->select("modules_content_sub",
			[
				"link", 
			],
            ["AND" => ["modules_content_id" => 14, "override" => "rightModule"]]
		);

        return $query[0]["link"];
		
	}

    public function getBanner(){

        $query = $this->db->select("modules_content",
			[
				"name",
                "content" 
			],
            ["AND" => ["id" => 15]]
		);

        return $query;
		
	}

    public function gallery(){
        $result = null;

        $checkQuery = $this->db->has("modules_content", [
				"AND" => ["type" => "gallery", "active" => 1]
			]
		);

        $checkQuery2 = $this->db->has("modules", [
				"AND" => ["moduleName" => "gallery", "moduleOn" => 1]
			]
		);
        
        if($checkQuery && $checkQuery2){
            $query = $this->db->select("modules_content",
                [
                    "link", 
                ],
                ["AND" => ["modules_id" => 13]]
            );

            $result = $query[0]["link"];
        }else{
            $result = false;
        }

        return $result;
        
		
	}

    //CRUD - create/read/update/delete
    public function update(string $table, string $status, string $name, int $id = null){

        $this->$database->update($table, 
            [$name => $status], 
            ["id" => $id]
        );

        return json_encode("updated");
    }

}

?>