<?php
session_start();

require_once "bd_utils.php";
require_once "class_concursant.php";
$concursants = obtenirConcursants("nom", $_POST["nom_amagat"]);
$i = 1;
foreach ($concursants as $concursant) {
    $concursant_update = new Concursant($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], $i);
    $concursant_update->updateConcursant($i . $_POST["nom_amagat"]);
    $i += 1;
    print_r($concursant_update);
    echo "<br>";
}

header("Location: admin.php?data=" . $_SESSION["data"]);
