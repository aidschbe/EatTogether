<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Account</title>

    <?php
    include_once("components/imports.php");
    include_once("components/session.php");
    ob_start();
    ?>

</head>

<body>

    <?php include_once("components/header.php"); ?>

    <div class="container text-center mb-3 col-3">

        <h1 id="user"><?php echo $_SESSION['userName']; ?></h1>

        <!-- ========== Start Profile Picture ========== -->

        <div class="m-5">
            <img class="img-fluid img-public mb-3" src="<?php echo $_SESSION['profilePicture']; ?>" alt="" height="120">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control text-start" type="file" name="newPicture" id="newPicture">
                </div>
                <button type="submit" name="changePicture" class="btn btn-primary btn-lg px-4">Change Profile Picture</button>
            </form>
            <?php
            if (isset($_POST["changePicture"])) {
                $newPicture = $_FILES["newPicture"];
                $uploadedFile = $userFunctions->uploadNewPicture($newPicture);
                if ($uploadedFile != false) {
                    $userFunctions->changeProfilePicture($uploadedFile);
                }
            }
            ?>
        </div>


        <!-- ========== End Profile Picture ========== -->

        <!-- ========== Start Public Message ========== -->

        <div class="m-5 pt-4 border-top">
            <h2 class="fw-bold">Public Message</h2>
            <form method="post">
                <div class="mb-3">
                    <textarea class="form-control" name="publicMessage" id="publicmessage"><?php echo $userFunctions->showPublicmessage() ?></textarea>
                </div>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="submit" name="editMessage" class="btn btn-primary btn-lg px-4">Edit Message</button>
                </div>
            </form>
            <?php
            if (isset($_POST["editMessage"])) {
                $newMessage = $_POST["publicMessage"];
                $userFunctions->changePublicMessage($newMessage);
            }
            ?>
        </div>

        <!-- ========== End Public Message ========== -->

        <!-- ========== Start Private Messages ========== -->

        <div class="m-5 pt-4 border-top">
            <h2 class="fw-bold">My Private Messages</h2>

            <div class="mb-3">
                <?php
                $messages = $userFunctions->getPrivateMessages();

                if ($messages == null) {
                    echo "No Messages yet! Go make some friends!";
                } else {

                    $conversations = array();

                    foreach ($messages as $message) {
                        if (!in_array($message->otheruser, $conversations)) {
                            array_push($conversations, $message->otheruser);
                        }
                    }

                    echo '<div class="dropdown my-3">';

                    echo '<button class="btn btn-primary my-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">Messages by User</button>';

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
                        <div class="modal fade" id="' . $conversation . '" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
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
                                            echo '<li><a class="dropdown-item group-invite" id="'.$group->id.'">'.$group->name.'</a></li>';                                                
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
                }


                if (isset($_POST["sendMessage"])) {
                    $userFunctions->sendPrivateMessage($_POST["message"], $_POST['sendMessage']);
                    header("Refresh:0");
                }
                ?>

            </div>

            <!-- ========== End Private Messages ========== -->

            <!-- ========== Start User City ========== -->

            <div class="m-5 pt-4 border-top">

                <h2 class="fw-bold">City</h2>
                <form method="post">
                    <div class="mb-3">
                        <input class="form-control" name="city" id="city" value="<?php echo $userFunctions->getCity(); ?>">
                    </div>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <button type="submit" name="editCity" class="btn btn-primary btn-lg px-4">Change City</button>
                    </div>
                </form>
                <?php
                if (isset($_POST["editCity"])) {
                    $newCity = $_POST["city"];
                    $userFunctions->changeCity($newCity);
                }
                ?>

            </div>

            <!-- ========== End User City ========== -->



        </div>

        <?php include_once("components/footer.php"); ?>

</body>

</html>