<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Groups</title>

    <?php
    include_once("components/imports.php");
    include_once("components/session.php");
    include_once("classes/group.php");
    ob_start();
    ?>

</head>

<body>

    <?php include_once("components/header.php"); ?>

    <div class="container text-center mb-3 col-3">

        <h1><?php echo $_SESSION['userName']; ?></h1>

        <div class="m-5">

            <img class="img-fluid img-public mb-3" src="<?php echo $_SESSION['profilePicture']; ?>" alt="" height="120">

            <div>
                <!-- Modal trigger button -->
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createNewGroup">
                    Create New Group
                </button>
            </div>

        </div>

        <!-- Modal Body -->
        <div class="modal fade" id="createNewGroup" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <form method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">Create New Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Group Name:</label>
                                <input type="text" class="form-control" name="groupName" id="groupName">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="createGroup" class="btn btn-primary">Create Group</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php
        if (isset($_POST["createGroup"])) {
            $groupFunctions->createGroup($_POST["groupName"]);
        }
        ?>

        <div class="row justify-content-center">
            <?php

            $userGroups = $groupFunctions->allUserGroups();

            foreach ($userGroups as $group) {

                echo '
                <div class="card col-auto m-3">
                <h4 class="card-title">' . $group->name . '</h4>
                <div class="card-body row">';



                $members = $groupFunctions->getMembers($group->id);

                foreach ($members as $member) {

                    echo "<div class='card-text'>" . $member->screenName . "</div>";
                }

                echo '
                <div class="mt-3">
                    <form method="post">
                    <button type="submit" name="leaveGroup" class="btn btn-primary">Leave Group</button>
                    </form>
                </div>
                ';

                echo '
                </div>
                </div>
            ';
            }
            ?>
        </div>

    </div>

    <?php include_once("components/footer.php"); ?>

</body>

</html>