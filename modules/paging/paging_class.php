<?php
class Paging {

	private $dataExist;
	private $pageSite;
	private $table;
	private $value;
	private $id;
	private $perPage;
	private $page;

	public function __construct(){

	}

	public function setPaging(string $pageSite, string $table, string $value, int $id = null, int $perPage, int $page){
		$this->pageSite = $pageSite;
		$this->table = $table;
		$this->value = $value;
		$this->id = $id;
		$this->perPage = $perPage;
		$this->page = $page;
	}

    public function getPaging(){
		
		require($_SERVER["DOCUMENT_ROOT"].'/includes/connection.php'); 

		//if exist
		if($database->has($this->table,[
			"AND" =>[$this->value => $this->id]
		])) {
			//count
			$countThread = $database->count($this->table, [$this->value => $this->id]);
        
			$totalPages = ceil($countThread / $this->perPage);
	
			//prev button
				if($this->page <=1 ){ 
					echo "<div class='pagingEnd'>Föregående</div>"; 
				}else{
					$j = $this->page - 1;
					echo "<a href='".$this->pageSite.".php?id=".$this->id."&page=$j'><div class='paging'>< Föregående</div></a>";
				}
	
				//number button
				for($i=1; $i <= $totalPages; $i++){
					if($i<>$this->page){
						echo "<a href='".$this->pageSite.".php?id=".$this->id."&page=$i'><div class='paging'>$i</div></a>";
					}else{
						echo "<div class='pagingCurrent'>$i</div>";
					}
				}
	
				//next button
				if($this->page == $totalPages){
					echo "<div class='pagingEnd'>Nästa</div>";
				}else{
					$j = $this->page + 1;
					echo "<a href='".$this->pageSite.".php?id=".$this->id."&page=$j'><div class='paging'>Nästa ></div></a>";
				}
		}
    }
    
} ?>