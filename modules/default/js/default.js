$(document).ready(function ($) {

    //sidebar
    $('.sideNavButton').on('click', function () {
        toggleSideMenu();
    });

    $('.bodyOverlay').on('click', function () {
        toggleSideMenu();
    });

    function toggleSideMenu() {
        $('.bodyOverlay').toggle();
        $('.sideNav').stop().animate({ width: 'toggle' }, 350)
        $("#sideNav").empty();
    }

    getLinks();

    function post(page){
        $.post("/modules/default/reciver.php", { page: page }, function (data) {
            $("#sideNav").html(data);
        })
    }

    function getLinks() {
        $.get("/modules/default/getLinks.php", function (data) {
            $.each(JSON.parse(data), function (key, value) {
                $(value.content).on("click", function () {
                    console.log(value.content);
                    post(value.link);
                });
            });
        })
    }
    
});