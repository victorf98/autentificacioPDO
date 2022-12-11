<?php
session_start();
require_once "bd_utils.php";
require_once "class_concursant.php";

//Creem un objecte concursant i l'insertem a la base de dades
$concursant_insert = new Concursant($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], 1);
$concursant_insert->insert();

header("Location: admin.php?data=" . $_SESSION["data"]);
?>