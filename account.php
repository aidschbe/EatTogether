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

    <div class="container text-center mb-3 col-4">

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