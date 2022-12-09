<?php

use FTP\Connection;

require_once "class_concursant.php";
require_once "bd_utils.php";
$concursant_obtingut = obtenirConcursants("id", $_POST["id"]);
$concursant = new Concursant($concursant_obtingut[0]["nom"], $concursant_obtingut[0]["imatge"], $concursant_obtingut[0]["amo"], $concursant_obtingut[0]["raça"], $concursant_obtingut[0]["fase"], $concursant_obtingut[0]["vots"]);
$concursant->afegirVot($_POST["id"]);
header("Location: index.php");
?>