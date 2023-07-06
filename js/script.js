$(document).ready(function () {

    $("img").click(function () {
        $(this).hide();
    });

    $(".card").click(function () {
        $(this).hide();
    });

    $(".form-control").mouseenter(function () {
        $(this).addClass("bg-info");
    });

    $(".form-control").mouseleave(function () {
        $(this).removeClass("bg-info");
    });

    $("#sendPM").click(function () {
        $("allPMs").hide();
    });


});