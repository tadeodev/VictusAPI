<?php

header('Content-Type: application/json');

require_once("../victusAPI.php");
require_once("../models/users_model.php");

$usuarios=new Users();
$body=json_decode(file_get_contents("php://input"), true);

switch($_GET["opt"]){
    case "GetAll": //Get all the info about users
        $datos=$usuarios->get_all();
        echo json_encode($datos);
    break;

    case "GetUsers": //Get the name of all users
        $datos=$usuarios->get_users();
        echo json_encode($datos);
    break;

    case "GetUsersIds": //Get all the IDs of all users
        $datos=$usuarios->get_users_ids();
        echo json_encode($datos);
    break;
    
    case "GetUserByName": //Get user info by name
        $datos=$usuarios->get_users_by_name($body["nameUser"]);
        echo json_encode($datos);
    break;

    case "GetUserById": //Get info of the user by ID
        $datos=$usuarios->get_users_by_id($body["internalId"]);
        echo json_encode($datos);
    break;

    case "GetDateCreation": //Get creation date of the account by the ID
        $datos=$usuarios->get_user_creation_date($body["public_Id"]);
        echo json_encode($datos);
    break;     

    case "AddUser": //Add users to the database
        $datos=$usuarios->add_user_database($body["telegramID"],$body["nameUser"],$body["LastNameUsr"],$body["UsrName"]);
        echo json_encode($datos);
    break; 
    
    case "AddAniUsr":
        $datos=$usuarios->add_anime_to_usr($body["nameAnime"],$body["telegramID"]);
        echo json_encode($datos);
    break;

    case "DelAniUsr":
        $datos=$usuarios->remove_anime_to_usr($body["nameAnime"],$body["telegramID"]);
        echo json_encode($datos);
    break;

    case "GetAnimesUsr":
        $val = $_GET["usr"];
        $datos=$usuarios->get_animes_of_usr($val);
        echo json_encode($datos);
    break;

    case "SetAniNoti":
        $datos=$usuarios->alter_anime_to_usr($body["lastEpisode"],$body["ani_id"],$body["telegramID"]);
        echo json_encode($datos);
    }  
?>