<?php
require_once "bd_utils.php";
$fase = obtenirFase($_POST["nFase"]);
if ($fase == []) {
    $fase_insert = new Fase($_POST["nFase"], date("Y-m-d", strtotime($_POST["dataInici"])), date("Y-m-d", strtotime($_POST["dataFi"])), []);
    $fase_insert->insert();
}else {
    $fase_update = new Fase($fase["nFase"], $_POST["dataInici"], $_POST["dataFi"]);
    $fase_update->updateFase();
}
header("Location: admin.php");
?>