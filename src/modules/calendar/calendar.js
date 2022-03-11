$(document).ready(function(){
    /***************************/
    /* variable 			   */
    /***************************/
    var id;
    
     if (getParameterByName('product_id') != null){
        id = getParameterByName('product_id');
    }else{
        id = getParameterByName('id');
    }
    
    //***************************/
    //* function	            */
    //***************************/
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        url = url.toLowerCase(); // This is just to avoid case sensitiveness  
        name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();// This is just to avoid case sensitiveness for query parameter name
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    //dropbox value data
    function getValue(value,value2){
        $.post("/res/ajax/getCalendar.php",{key: value, id: value2},function(data){
            $("#body").html(data);
        });
    }

    /***************************/
    /* on change			   */
    /***************************/
    $("#month").change(function() {    
        var title = $("#month option:selected").text();
        var calendar = $("#month option:selected").val();
                                    
        $("#title").html(title); 

        getValue(calendar, id);

    });

    /***************************/
    /* start 			       */
    /***************************/
    getValue("0", id)

});