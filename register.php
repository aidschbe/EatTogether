<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <?php
    include_once("components/imports.php");
    include_once("components/session.php");
    ?>

</head>

<body>

    <?php include_once("components/header.php"); ?>


    <div class="container text-center">
        <form method="post">
            <h1>Please register</h1>
            <div>
                <label for="floatingInput">Email address</label>
                <input type="email" class="form-control" id="floatingInput" name="regEmail" placeholder="name@example.com">
            </div>
            <div>
                <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" id="floatingPassword" name="regPassword" placeholder="Password">
            </div>
            <div>
                <label for="floatingInput">User Name</label>
                <input class="form-control" id="floatingInput" name="regScreenName" placeholder="Sh4d0wK1ll0r69">
            </div>
            <div>
                <label for="floatingInput">City</label>
                <input class="form-control" id="floatingInput" name="regCity" placeholder="Musterstadt">
            </div>
            <div>
                <label for="floatingInput">First Name</label>
                <input class="form-control" id="floatingInput" name="regFirstName" placeholder="Maria">
            </div>
            <div>
                <label for="floatingInput">Last Name</label>
                <input class="form-control" id="floatingInput" name="regLastName" placeholder="Musterfrau">
            </div>
            <div>
                <label for="floatingInput">Gender</label>
                <select class="form-control" id="floatingInput" name="regGender">

                    <option value=""></option>

                    <?php
                    $genders = $userFunctions->genderOptions();

                    foreach ($genders as $gender) {
                        echo "<option value='" . $gender->id . "'>$gender->name</option>";
                    }

                    ?>

                </select>
            </div>
            <div>
                <label for="floatingInput">Birthday</label>
                <input type="date" class="form-control" id="floatingInput" name="regBirthday">
            </div>

            <button name="register" class="btn btn-primary my-3 py-2" type="submit">Register</button>
        </form>


    </div>

    <?php
    if (isset($_POST["register"])) {

        $email = $_POST["regEmail"];
        $password = $_POST["regPassword"];
        $screenName = $_POST["regScreenName"];
        $city = $_POST["regCity"];
        $firstName = $_POST["regFirstName"];
        $lastName = $_POST["regLastName"];
        $gender = $_POST["regGender"];
        $birthday = $_POST["regBirthday"];

        echo $userFunctions->register($email, $password, $screenName, $city, $firstName, $lastName, $gender, $birthday);
    }
    ?>

    <?php include_once("components/footer.php"); ?>

</body>

</html>