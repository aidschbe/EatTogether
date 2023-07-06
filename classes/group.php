<?php

include_once("dbpdo.php");

class Group
{

    function allUserGroups()
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT usergroup as id, usergroups.name as name FROM groupmembers
        INNER JOIN usergroups ON usergroups.id = groupmembers.usergroup
        WHERE user = ? AND active = ?");

        $sql->execute(array($_SESSION["userId"], 1));

        $groups = $sql->fetchAll();

        return $groups;
    }

    function createGroup($groupName)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("INSERT INTO usergroups (name) VALUES (?)");
        $sql->execute([$groupName]);

        $sql = $conn->prepare("SELECT LAST_INSERT_ID() as id");
        $sql->execute();
        $groupId = $sql->fetch()->id;

        $sql = $conn->prepare("INSERT INTO groupmembers (usergroup, user, active) VALUES (?, ?, ?)");
        $sql->execute([$groupId, $_SESSION["userId"], 1]);

        return "Group " . $groupName . " successfully created.";
    }

    function leaveGroup($groupId)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("UPDATE groupmembers SET active = ? WHERE usergroup = ? AND user = ?");
        $sql->execute([0, $groupId, $_SESSION["userId"]]);

        return "Group left.";
    }

    function deleteGroup($groupId)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("DELETE FROM groupmembers WHERE usergroup = ?");
        $sql->execute([$groupId]);

        $sql = $conn->prepare("DELETE FROM usergroups WHERE id = ?");
        $sql->execute([$groupId]);

        return "Group successfully deleted.";
    }


    function enterGroup($group)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("INSERT INTO groupmembers (usergroup, user, active) VALUES (?, ?, ?)");
        $sql->execute([$group, $_SESSION["userId"], 1]);

        return "Group joined.";
    }

    function getMembers($groupId)
    {
        $db = new DBPDO;

        $conn = $db->connect();

        $sql = $conn->prepare("SELECT groupmembers.user, users.screenName FROM groupmembers
        INNER JOIN users ON groupmembers.user = users.id
        WHERE groupmembers.usergroup = ? AND groupmembers.active = ?");

        $sql->execute(array($groupId, 1));

        $members = $sql->fetchAll();

        return $members;
    }
}
