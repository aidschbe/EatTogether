<?php

class DBPDO
{

  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $database = "eattogether";

  function connect()
  {
    try {

      $conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    return $conn;
  }
}
