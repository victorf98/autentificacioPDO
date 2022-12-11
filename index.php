<?php
session_start();
require_once "bd_utils.php";
//Establim la data, la del dia actual o la que es passi per GET
if (isset($_GET["data"])) {
    $_SESSION["data"] = date("Y-m-d", strtotime($_GET["data"]));
} else {
    $_SESSION["data"] = date("Y-m-d");
}

//Si s'intenta entrar abans de temps només es veurà un formulari de login pels admins
if ($_SESSION["data"] < obtenirFase(1)["dataInici"]) {
?>
    <h2>Accés administradors</h2>
    <form action="process_login_admin.php" method="POST">
        <input type="text" name="usuari" placeholder="Usuari">
        <input type="password" name="contrasenya" placeholder="Contrasenya">
        <input type="submit" value="Entra">
    </form>
<?php

//Si intentem entrar després de les fases ens porta directe a la pantalla de resultats
} elseif ($_SESSION["data"] > obtenirFase(8)["dataFi"]) {
    header("Location: resultats.php");
} else {
    $fase_actual = trobarFasePerData($_SESSION["data"]);
    $_SESSION["fase"] = ["nFase" => $fase_actual["nFase"], "dataInici" => $fase_actual["dataInici"], "dataFi" => $fase_actual["dataFi"]];

    /**
     * Si és una nova fase on encara no s'han fet els càlculs, 
     * es fan els càlculs per obtenir els nous concursants i es creen
     */
    if (obtenirConcursants("fase", $_SESSION["fase"]["nFase"]) == null) {
        crearConcursantsNovaFase(obtenirConcursantsNovaFase($_SESSION["fase"]["nFase"] - 1), $_SESSION["fase"]["nFase"]);
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

                <p class="warning"> <?php if (isset($_SESSION["vot_fase_" . $_SESSION["fase"]["nFase"]])) echo $_SESSION["missatge"] ?></p>
                <div class="poll-area">
                    <?php
                    $concursants = obtenirConcursants("fase", $_SESSION["fase"]["nFase"]);
                    /**
                     * Si només hi ha 1 concursant (en cas que hi hagi menys de 9 concursants) 
                     * es mostra aquest sense el botó per votar
                     */
                    if (count($concursants) == 1) {
                    ?>
                        <form action="process_votar.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $concursants[0]["id"] ?>">
                            <label for="<?php echo $concursants[0]["id"] ?>" class="<?php echo $concursants[0]["id"] ?>">
                                <span class="text" style="color: red;">Guanyador!</span>
                                <div class="row">
                                    <div class="column">
                                        <div class="right">
                                            <span class="text"><?php echo $concursants[0]["nom"] ?></span>
                                        </div>
                                        <img class="dog" alt="Musclo" src="img/<?php echo $concursants[0]["imatge"] ?>">
                                    </div>
                                </div>
                            </label>
                        </form>
                        <?php
                    } elseif (count($concursants) > 1) {
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
                    }
                    ?>
                </div>

                <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
            </div>
        </div>

    </body>

    </html>
<?php
}
?>