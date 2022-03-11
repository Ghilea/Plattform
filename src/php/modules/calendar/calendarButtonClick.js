$(document).ready(function() {
    
    /***************************/
	/* click get date          */
	/***************************/
    $(".boxCalendar").on("click", function(){
			
		if (!$(this).hasClass("calendarDateEvent") && !$(this).hasClass("calendarDateOld")){
			var date = $(this).find("input").val();
			$("#added").val(date);
		}
	});

});