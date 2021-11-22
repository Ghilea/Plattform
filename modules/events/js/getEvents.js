$(document).ready(function ($) {

    $('.press').on('click', function () {
        test();
    });

    function test(){
        console.log("test");
        $.get("/modules/events/addEvents.php", function (data) {
            console.log("test2");
            $("#output").html(data);
        }, "json");
    }


});