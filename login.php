<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <?php
    include_once("components/imports.php");
    include_once("components/session.php");
    ob_start();
    ?>

</head>

<body>

    <?php include_once("components/header.php"); ?>

    <div class="container">

        <div class="justify-content-center text-center row">
            <form class="col-6" method="post">
                <h1>Please sign in</h1>
                <div class="my-3">
                    <input class="form-control" id="floatingInput" name="loginUser" placeholder="username/e-mail">
                </div>
                <div class="input-group my-3">
                    <input type="password" class="form-control rounded z-2 pw pw-hide" id="floatingPassword" name="loginPassword" placeholder="password">
                    <span class="input-group-text position-absolute end-0 z-3">
                        <i class="bi bi-eye pw-toggle"></i>
                    </span>
                </div>
                <button name="login" class="btn btn-primary my-3 py-2" type="submit">Log in</button>
            </form>
        </div>

    </div>

    <?php
    if (isset($_POST["login"])) {

        $userFunctions = new User;

        $user = $_POST["loginUser"];
        $pw = $_POST["loginPassword"];
        $login = $userFunctions->login($user, $pw);

        echo <<<HTML
        <div>$login</div>
        HTML;
    }
    ?>

    <?php include_once("components/footer.php"); ?>


</body>

</html>