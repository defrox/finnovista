jQuery(document).ready(function($){

    $(".multibox").click(function(){
        console.log($(this).attr('name'));

        var favorite = [];

        $.each($("input[name='sport']:checked"), function(){

            favorite.push($(this).val());

        });

        alert("My favourite sports are: " + favorite.join(", "));

    });

});