<?php
    switch ($_GET['users']) {
        case "Rob":
            $users = array("firstname" => "Robert", "surname" => "Steyn");
            echo json_encode($users);
            break;
        case "Niel":
            $users = array("firstname" => "Niel", "surname" => "Pretorius");
            echo json_encode($users);
            break;
        case "Dries":
            $users = array("firstname" => "Dries", "surname" => "Pretorius");
            echo json_encode($users);
            break;

        default:
            break;
    }


