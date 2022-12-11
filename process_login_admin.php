<?php
session_start();

    session_start();
    require_once "bd_utils.php";
     $usuari = obtenirUsuari($_POST["usuari"], $_POST["contrasenya"]);
     //Si l'usuari no és a la base de dades redirigim a l'index
     if ($usuari == null) {
        unset($_SESSION["usuari"]);
        header("Location: index.php");
      //Si no hi és accedim a admin
     }else {
        $_SESSION["usuari"] = $usuari->user;
        header("Location: admin.php?data=" . $_SESSION["data"]);
     }
?>