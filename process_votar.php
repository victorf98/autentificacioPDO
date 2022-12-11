<?php
session_start();

require_once "class_concursant.php";
require_once "bd_utils.php";

//Si ja s'ha votat ens borra el vot prèviament fet i ens posa el vot a on hem seleccionat
if (isset($_SESSION["vot_fase_" . $_SESSION["fase"]["nFase"]])) {
    $concursant_anitc = obtenirConcursants("id", $_SESSION["vot_fase_" . $_SESSION["fase"]["nFase"]]["id"]);
    $concursant = new Concursant($concursant_anitc[0]["nom"], $concursant_anitc[0]["imatge"], $concursant_anitc[0]["amo"], $concursant_anitc[0]["raça"], $concursant_anitc[0]["fase"], $concursant_anitc[0]["vots"]);
    $concursant->treureVot();
    $concursant_obtingut = obtenirConcursants("id", $_POST["id"]);
    $concursant = new Concursant($concursant_obtingut[0]["nom"], $concursant_obtingut[0]["imatge"], $concursant_obtingut[0]["amo"], $concursant_obtingut[0]["raça"], $concursant_obtingut[0]["fase"], $concursant_obtingut[0]["vots"]);
    $concursant->afegirVot();
//Si és el primer cop que es vota només afegim el vot
} else {
    $concursant_obtingut = obtenirConcursants("id", $_POST["id"]);
    $concursant = new Concursant($concursant_obtingut[0]["nom"], $concursant_obtingut[0]["imatge"], $concursant_obtingut[0]["amo"], $concursant_obtingut[0]["raça"], $concursant_obtingut[0]["fase"], $concursant_obtingut[0]["vots"]);
    $concursant->afegirVot();
}

//Guardem el gos al que s'ha votat
$_SESSION["vot_fase_" . $_SESSION["fase"]["nFase"]] = ["nom" => $concursant->nom, "id" => $concursant->id];
//Creem el missatge informatiu que diu que ja hem votat
$_SESSION["missatge"] = "Ja has votat al gos " . $_SESSION["vot_fase_" . $_SESSION["fase"]["nFase"]]["nom"] . 
". Es modificarà la teva resposta";
header("Location: index.php?data=" . $_SESSION["data"]);
