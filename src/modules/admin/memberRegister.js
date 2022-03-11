$(document).ready(function(){
    
    /***************************/
    /* function                */
    /***************************/
    function getSearch(value){		
		$.post("/res/ajax/getMemberRegister.php", {search:value},function(data){
			$("#results").html(data);
		})
	};
    
	/***************************/
    /* search                  */
    /***************************/
    $("input[type='search'][name='search']").keyup(function(){
        
        if($(this).val().length == ""){
            getSearch("_");
        }
        
        var value = $("input[type='search'][name='search']").val();
        
        getSearch(value);
    });
    
    /***************************/
    /* start                   */
    /***************************/ 
	getSearch("_");

});
