$(document).ready(function () {

    // toggle password visibility
    $(".pw-toggle").click(function () {

        $(this).toggleClass("bi-eye bi-eye-slash")

        $(".pw").toggleClass("pw-hide pw-show")

        $(".pw-hide").prop("type", "password")

        $(".pw-show").prop("type", "text")

    });

    // send private message
    $(".sendmsgbtn").click(function () {

        var conversation = $(".show")

        var recipient = conversation.find(".sendmsgbtn").val();
        var message = conversation.find(".messageToSend").val();
        var sender = $("#user").text();
        var timestamp = new Date();
        timestamp = timestamp.getHours() + ":" + timestamp.getMinutes()

        if (message.length > 0) {

            $.post("/hemmer/eattogether/ajax/sendPrivateMessage.php", {
                recipient: recipient,
                message: message
            });


            var newMessage = "<div class='my-2'>" +
                '<div class="fw-light">Today:</div>' +
                '<div class="fw-light">' + timestamp + " " + sender + "</div>" +
                '<div class="fw-normal text -break">' + message + "</div>" +
                '</div >';

            conversation.find("#allPMs").append(newMessage);
        }

    });

    // TODO: invite to group
    $(".group-invite").click(function () {

        var conversation = $(".show")

        console.log($(this).attr('id'));

        // var recipient = conversation.find(".sendmsgbtn").val();
        // var groupId = $(this).val();

        // $.post("/hemmer/eattogether/ajax/inviteToGroup.php", {
        //     recipient: recipient,
        //     groupId: groupId,
        // });


    });

    // TODO: load new private messages
    function newPMs() {

    }

    // TODO: poll for new private messages every 3 seconds
    if ($(".show").length > 0) {

        setTimeout(newPMs, 3000)
    }

});