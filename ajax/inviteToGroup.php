<?php

include_once("../components/imports.php");
include_once("../components/session.php");

$groupId = $_REQUEST['groupId'];
$user = $_REQUEST['recipient'];

$groupFunctions->sendInvite($groupId, $user);