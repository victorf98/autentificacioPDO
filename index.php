<?php
session_start();
require_once "bd_utils.php";
$fase_actual = trobarFasePerData(date("Y-m-d"));
if ($fase_actual == null) {
    $fase_actual = obtenirFase(8);
}
$_SESSION["fase"] = $fase_actual;
if (obtenirConcursants("fase", $_SESSION["fase"]["nFase"]) == null) {
    //crearConcursantsNovaFase(obtenirConcursants("fase", $_SESSION["fase"]["nFase"] - 1));
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <h2>Accés administradors</h2>
        <form action="process_login_admin.php" method="POST">
            <input type="text" name="usuari" placeholder="Usuari">
            <input type="password" name="contrasenya" placeholder="Contrasenya">
            <input type="submit" value="Entra">
        </form>
        <br>
        <div class="wrapper">
            <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span> <?php echo $_SESSION["fase"]["nFase"] ?> </span></header>
            <p class="info"> Podeu votar fins el dia <?php echo date("d-m-Y", strtotime($_SESSION["fase"]["dataFi"])) ?></p>

            <p class="warning"> Ja has votat al gos MUSCLO. Es modificarà la teva resposta</p>
            <div class="poll-area">
                <?php
                $concursants = obtenirConcursants("fase", strtotime($_SESSION["fase"]["dataFi"]));
                foreach ($concursants as $concursant) {
                ?>
                    <form action="process_votar.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $concursant["id"] ?>">
                        <label for="<?php echo $concursant["id"] ?>" class="<?php echo $concursant["id"] ?>">
                            <div class="row">
                                <div class="column">
                                    <div class="right">
                                        <span class="text"><?php echo $concursant["nom"] ?></span>
                                    </div>
                                    <img class="dog" alt="Musclo" src="img/<?php echo $concursant["imatge"] ?>">
                                </div>
                            </div>
                            <input type="submit" value="Votar">
                        </label>
                    </form>
                <?php
                }
                ?>
            </div>

            <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
        </div>
    </div>

</body>

</html>