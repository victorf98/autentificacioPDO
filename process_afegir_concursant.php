<?php
require_once "bd_utils.php";
require_once "class_concursant.php";
$concursant_insert = new Concursant($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], 1);
$concursant_insert->insert();

header("Location: admin.php");
?>