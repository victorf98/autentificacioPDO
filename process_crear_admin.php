<?php
session_start();

require_once "class_admin.php";

//Creem un objecte admin i l'insertem a la base de dades
$admin = new Admin($_POST["usuari"], $_POST["contrasenya"]);
$admin->insert();
header("Location: admin.php?data=" . $_SESSION["data"]);
?>