<?php
    session_start();
    require_once "bd_utils.php";
     $usuari = obtenirUsuari($_POST["usuari"], $_POST["contrasenya"]);
     if ($usuari == null) {
        unset($_SESSION["usuari"]);
        header("Location: index.php");
     }else {
        $_SESSION["usuari"] = $usuari->user;
        header("Location: admin.php");
     }
?>