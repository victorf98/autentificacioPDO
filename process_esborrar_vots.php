<?php
session_start();

require_once "bd_utils.php";
require_once "class_concursant.php";

/**
 * Borrem els vots d'una fase en concret, si és la fase 1 posem els vots a 0,
 * si és una altra fase borrem els registres de concursants d'aquesta fase 
 * per així poder tornar a fer càlculs
 */
if (isset($_POST["nFase"])) {
    if ($_POST["nFase"] == 1) {
        update(CONCURSANT, "vots", 0, "fase", $_POST["nFase"]);
    } else {
        delete(CONCURSANT, "fase", $_POST["nFase"]);
    }
//Borrem tots els registres de concursants menys els de la fase 1 i posem a 0 els de la fase 1
} else {
    updateTot(CONCURSANT, "vots", 0, "id", 0);
    deleteTot(CONCURSANT, "fase", 1);
}
header("Location: admin.php?data=" . $_SESSION["data"]);
