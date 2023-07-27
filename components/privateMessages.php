<?php

include_once("components/session.php");
include_once("components/imports.php");

$messages = $userFunctions->getPrivateMessages();

$conversations = array();

foreach ($messages as $message) {
    if (!in_array($message->otheruser, $conversations)) {
        array_push($conversations, $message->otheruser);
    }
}

echo '<div class="dropdown">';

echo '<button class="btn btn-dark" type="button" data-bs-toggle="dropdown"><i class="bi bi-envelope h3"></i></button>';

echo '<ul class="dropdown-menu">';

foreach ($conversations as $conversation) {

    echo '
        <li>
            <a class="dropdown-item" data-bs-toggle="modal" role="button" data-bs-target="#' . $conversation . '">
                ' . $conversation . '
            </a>
        </li>';
}

echo "</ul>";
echo "</div>";
echo "</div>";

foreach ($conversations as $conversation) {

    $dates = array();

    foreach ($messages as $message) {

        if ($message->otheruser == $conversation) {
            $date = $message->date;
            if (!in_array($date, $dates)) {
                array_push($dates, $date);
            }
        }
    }

    echo '
        <div class="modal fade text-bg-light" id="' . $conversation . '" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Your conversations with ' . $conversation . '</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start" id="allPMs">';

    foreach ($dates as $date) {

        echo '<div class="h5 mt-3 pb-3 border-bottom">' . $date . '</div>';
        foreach ($messages as $message) {

            if ($message->otheruser == $conversation && $date == $message->date) {

                echo "<div class='my-2'>";
                echo "<div class='fw-light'>" . $message->timestamp . " " . $message->sender . "</div>";
                echo "<div class='fw-normal text-break'>" . $message->message . "</div>";
                echo "</div>";
            }
        }
    }

    $id = $userFunctions->getIdFromName($conversation);

    echo '
        </div>
        <div class="modal-footer">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Invite to group:
                </button>
                <ul class="dropdown-menu">';

    $groups = $groupFunctions->allUserGroups();
    foreach ($groups as $group) {
        echo '<li><a class="dropdown-item group-invite" id="' . $group->id . '">' . $group->name . '</a></li>';
    }

    echo '
                        </ul>
                    </div>
                    <input class="py-1 messageToSend" type="text" name="message" id="message">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" name="sendMessage" id="sendPM" class="btn btn-primary sendmsgbtn" value="' . $id . '">Send</button>
                </div>
            </div>
        </div>
    </div>
                        ';
}



if (isset($_POST["sendMessage"])) {
    $userFunctions->sendPrivateMessage($_POST["message"], $_POST['sendMessage']);
    header("Refresh:0");
}