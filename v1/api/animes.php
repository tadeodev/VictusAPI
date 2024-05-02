<?php

header('Content-Type: application/json');

require_once("../victusAPI.php");
require_once("../models/anime_model.php");

$animes=new Animes();
$body=json_decode(file_get_contents("php://input"), true);


switch($_GET["opt"]){
    case "GetAll": //GET Get all the info about users
        $datos=$animes->get_all();
        echo json_encode($datos);
    break;

    case "GetAnimes": //GET Get the name of all users
        $datos=$animes->get_name();
        echo json_encode($datos);
    break;
    
    case "GetAnimeByName": //POST Get user info by name
        $datos=$animes->get_anime_by_name($body["name"]);
        echo json_encode($datos);
    break;

    case "GetAnimeById": //POST info of the user by ID
        $datos=$animes->get_anime_by_id($body["ani_id"]);
        echo json_encode($datos);
    break;

    case "GetDateCreation": //POST Get creation date of the account by the ID
        $datos=$animes->get_anime_addition_date($body["animeID"]);
        echo json_encode($datos);
    break;     

    case "AddAnime": //POST Send the anime info to the DB
        $datos=$animes->add_anime_database($body["Name"],$body["Season"],$body["Episodes"],$body["Last_Episode"]);
        echo json_encode("Se ha añadido correctamente");
    break; 

    case "UpdateLastEpisode": //POST Send the info of the new cap to the DB
        $datos=$animes->update_anime_lastepisode($body["Name"],$body["Last_Episode"]);
        echo json_encode("Se ha actualizado correctamente");
    break;

    case "Find":
        $datos=$animes->find($body["Name"]);
        echo json_encode($datos);
    break;
}  
?>