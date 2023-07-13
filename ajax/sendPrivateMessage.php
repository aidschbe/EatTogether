<?php

include_once("../components/imports.php");
include_once("../components/session.php");

$text = $_REQUEST['message'];
$user = $_REQUEST['recipient'];

$userFunctions->sendPrivateMessage($text, $user);
