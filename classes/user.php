<?php

include_once("dbpdo.php");

class User
{
    function showOtherUsers()
    {

        $db = new DBPDO;

        $conn = $db->connect();

        if (isset($_SESSION["userId"])) {
            $sql = $conn->prepare("SELECT id, screenName, picture, publicMessage FROM users WHERE NOT id = ?");
            $sql->execute([$_SESSION["userId"]]);
        } else {
            $sql = $conn->prepare("SELECT id, screenName, picture, publicMessage FROM users");
            $sql->execute();
        }

        return $sql->fetchAll();
    }

    function login($user, $password)
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT id, picture, screenName FROM users WHERE password = ? AND (email = ? OR screenName = ?)");

        $sql->execute(array($password, $user, $user));



        if ($sql->rowCount() == 1) {
            $user = $sql->fetch();
            $_SESSION['userId'] = $user->id;
            $_SESSION['profilePicture'] = $user->picture;
            $_SESSION['userName'] = $user->screenName; 
            header("location:index.php");
            return "Login successful!";
        } else {
            return "Error: Wrong login details.";
        }
    }

    function register($email, $password, $screenName, $city, $firstName, $lastName, $gender, $birthday)
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT email, screenName FROM users WHERE email = ? OR screenName = ?");

        $sql->execute(array($email, $screenName));

        if ($sql->rowCount() > 0) {
            return "Error: Email or Username already exists.";
        } else {

            $defaultPicture = "images\default_avatar.png";
            $defaultMessage = "Placeholder: Be Excellent To Each Other And Party On, Dudes.";

            $sql = $conn->prepare("INSERT INTO
            users (password, email, screenName, city, firstName, lastName, gender, birthday, picture, publicMessage)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $sql->execute([$password, $email, $screenName, $city, $firstName, $lastName, $gender, $birthday, $defaultPicture, $defaultMessage]);

            return "Registration successful. You can log in now. =)";
        }
    }

    function logout()
    {
        session_destroy();
        header("location:index.php");
    }

    function genderOptions()
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT id, name FROM genders");

        $sql->execute();

        $genders = $sql->fetchAll();

        return $genders;
    }

    function getIdFromName($username){

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT id FROM users WHERE screenName = ?");

        $sql->execute([$username]);

        $id = $sql->fetch()->id;

        return $id;

    }

    function showPublicmessage()
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT publicMessage FROM users WHERE id = ?");

        $sql->execute([$_SESSION["userId"]]);

        $publicMessage = $sql->fetch()->publicMessage;

        return $publicMessage;
    }

    function changePublicMessage($newMessage)
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("UPDATE users SET publicMessage = ? WHERE id = ?");

        $sql->execute([$newMessage, $_SESSION['userId']]);

        header("Refresh:0");
    }

    function changeProfilePicture($newPicture)
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("UPDATE users SET picture = ? WHERE id = ?");

        $sql->execute([$newPicture, $_SESSION['userId']]);

        $_SESSION['profilePicture'] = $newPicture;

        header("Refresh:0");
    }

    function uploadNewPicture($file)
    {

        $target_dir = "images\\";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);

        if ($check !== false) {
            move_uploaded_file($file["tmp_name"], $target_file);
            return $target_file;
        } else {
            echo "File is not an image.";
            return false;
        }
    }

    function changeCity($city)
    {

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("UPDATE users SET city = ? WHERE id = ?");

        $sql->execute([$city, $_SESSION['userId']]);

        header("Refresh:0");
    }

    function getCity()
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT city FROM users WHERE id = ?");

        $sql->execute([$_SESSION['userId']]);

        $city = $sql->fetch()->city;

        return $city;
    }

    function sendPrivateMessage($message, $recipient)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("INSERT INTO privateMessages (sender, recipient, message) VALUES (?, ?, ?)");

        $sql->execute([$_SESSION['userId'], $recipient, $message]);

    }

    function getPrivateMessages(){

        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT senders.screenName as sender, recipients.screenName as recipient, message, timestamp
        FROM privateMessages
        INNER JOIN users AS senders ON sender = senders.id
        INNER JOIN users AS recipients ON recipient = recipients.id
        WHERE sender = ? OR recipient = ? ORDER BY timestamp");

        $sql->execute([$_SESSION['userId'], $_SESSION['userId']]);

        $messages = $sql->fetchAll();

        foreach ($messages as $message) {
            $message->timestamp = DateTime::createFromFormat("Y-m-d H:i:s", $message->timestamp);
            $message->date = $message->timestamp->format("Y/M/d");
            $message->timestamp = $message->timestamp->format("G:i");
        }

        foreach ($messages as $message) {

            if ($message->sender == $_SESSION['userName']) {
                $message->otheruser = $message->recipient;
            } else {
                $message->otheruser = $message->sender;
            }
        }

        return $messages;
    }

}
