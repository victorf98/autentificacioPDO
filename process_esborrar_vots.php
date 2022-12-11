<?php
session_start();

    require_once "bd_utils.php";
    require_once "class_concursant.php";
    if (isset($_POST["nFase"])) {
        delete(CONCURSANT, "fase", $_POST["nFase"]);
    }else {
        updateTot(CONCURSANT, "vots", 0, "id", 0);
        deleteTot(CONCURSANT, "fase", 1);
    }
    header("Location: admin.php?data=" . $_SESSION["data"]);
