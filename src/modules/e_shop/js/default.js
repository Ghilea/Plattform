$(document).ready(function ($) {

    //sidebar
    $('.addProduct').on('click', function () {
        let id = $(this).attr('id');
        addProduct(id);
    });

    function addProduct(id){
        console.log(id);
        $.post("/modules/e_shop/ajax_addProduct.php", { id: id }, function () {
          $(".showProduct").html(1);
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