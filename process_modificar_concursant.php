<?php
require_once "bd_utils.php";
require_once "class_concursant.php";
$concursant = obtenirConcursants("id", "1" . $_POST["nom"]);
$concursant_update = new Concursant($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], 1);
$concursant_update->updateConcursant($concursant[0]["id"]);
header("Location: admin.php");
?>