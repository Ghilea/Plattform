$(document).ready(function($){

/***************************/
/* serialize form input	   */
/***************************/
(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);

/***************************/
/* form submit			   */
/***************************/
$('#registrationForm').submit(function (e) {
	e.preventDefault();
	var data = $(this).serializeFormJSON();

	$.post("/res/ajax/ajax_registration.php", {email: data.email, password: data.password },function(data){
		$("#registrationResults").html(data);
	})
});

});