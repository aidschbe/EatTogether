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
    ?>

</head>

<body>

    <?php include_once("components/header.php"); ?>

    <div class="container text-center">
        <form method="post">
            <h1>Please sign in</h1>
            <div>
                <label for="floatingInput">Email address</label>
                <input class="form-control" id="floatingInput" name="loginUser" placeholder="name@example.com">
            </div>
            <div>
                <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" id="floatingPassword" name="loginPassword" placeholder="Password">
            </div>
            <button name="login" class="btn btn-primary my-3 py-2" type="submit">Log in</button>
        </form>

        <?php
        if (isset($_POST["login"])) {

            $userFunctions = new User;

            $user = $_POST["loginUser"];
            $pw = $_POST["loginPassword"];

            echo "<div>" . $userFunctions->login($user, $pw) . "</div>";
        }
        ?>

    </div>

    <?php include_once("components/footer.php"); ?>


</body>

</html>