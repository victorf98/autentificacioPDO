<?php
require_once "class_admin.php";
$admin = new Admin($_POST["usuari"], $_POST["contrasenya"]);
$admin->insert();
header("Location: admin.php");
?>