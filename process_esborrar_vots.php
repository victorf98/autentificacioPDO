<?php
    require_once "bd_utils.php";
    require_once "class_concursant.php";
    if (isset($_POST["nFase"])) {
        update(CONCURSANT, "vots", 0, "fase", $_POST["nFase"]);
    }else {
        updateTot(CONCURSANT, "vots", 0, "id", 0);

    }
    header("Location: admin.php");
?>