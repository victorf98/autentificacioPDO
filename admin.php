<?php
session_start();
require_once "bd_utils.php";

//Si el login s'ha fet malament ens redirigeix a index.php
if (!isset($_SESSION["usuari"])) {
    header("Location: index.php");
} else {
    /**
     * Si no hi ha cap fase creada (la fase 1) 
     * es creen automàticament amb la duració d'1 mes començant per cada mes de 2023
     */
    if (obtenirFase(1) == null) {
        $datesInici = ["2023-01-01", "2023-02-01", "2023-03-01", 
        "2023-04-01", "2023-05-01", "2023-06-01", "2023-07-01", "2023-08-01"];
        $datesFi = ["2023-01-31", "2023-02-28", "2023-03-31", "2023-04-30",
         "2023-05-31", "2023-06-3", "2023-07-31", "2023-08-31"];
        for ($i=0; $i < 8; $i++) { 
            $fase = new Fase($i + 1, $datesInici[$i], $datesFi[$i]);
            $fase->insert();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="wrapper medium">
            <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
            <div class="admin">
                <div class="admin-row">
                    <h1> Resultat parcial: Fase <?php echo $_SESSION["fase"]["nFase"] ?> </h1>
                    <div class="gossos">
                        <?php
                        /**
                         * Si un concursant de la fase actual no estaria a la 
                         * següent fase sortirà en blanc i negre
                         */
                        $concursants = obtenirConcursants("fase", $_SESSION["fase"]["nFase"]);
                        $nous_concursants = obtenirConcursantsNovaFase($_SESSION["fase"]["nFase"]);
                        foreach ($concursants as $concursant) {
                            $trobat = false;
                            foreach ($nous_concursants as $nou_concursant) {
                                if ($concursant["nom"] == $nou_concursant["nom"]) {
                        ?>
                                    <img class="dog" alt="<?php echo $concursant["nom"] ?>" title="<?php echo $concursant["nom"] . 
                                    " " . $concursant["vots"] ?>" src="img/<?php echo $concursant["imatge"] ?>">
                            <?php
                                    $trobat = true;
                                }
                            }
                            if (!$trobat) {
                        ?>
                        <img class="dog eliminat" alt="<?php echo $concursant["nom"] ?>" title="<?php echo $concursant["nom"] . 
                                    " " . $concursant["vots"] ?>" src="img/<?php echo $concursant["imatge"] ?>">
                        <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="admin-row">
                    <h1> Nou usuari: </h1>
                    <form action="process_crear_admin.php" method="POST">
                        <input type="text" name="usuari" placeholder="Nom">
                        <input type="password" name="contrasenya" placeholder="Contrassenya">
                        <input type="submit" value="Crea usuari">
                    </form>
                </div>
                <div class="admin-row">
                    <h1> Fases: </h1>
                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="1" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(1) != null) echo obtenirFase(1)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(1) != null) echo obtenirFase(1)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="2" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(2) != null) echo obtenirFase(2)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(2) != null) echo obtenirFase(2)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="3" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(3) != null) echo obtenirFase(3)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(3) != null) echo obtenirFase(3)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="4" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(4) != null) echo obtenirFase(4)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(4) != null) echo obtenirFase(4)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="5" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(5) != null) echo obtenirFase(5)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(5) != null) echo obtenirFase(5)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="6" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(6) != null) echo obtenirFase(6)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(6) != null) echo obtenirFase(6)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="7" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(7) != null) echo obtenirFase(7)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(7) != null) echo obtenirFase(7)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="8" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (obtenirFase(8) != null) echo obtenirFase(8)["dataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (obtenirFase(8) != null) echo obtenirFase(8)["dataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                </div>

                <div class="admin-row">
                    <h1> Concursants: </h1>

                    <?php
                    /**
                     * Mostrarem els tots els concursants per modificar 
                     * (posem la fase 1 perquè no hi haurà cap eliminat i sortiran tots)
                     */
                    $concursants = obtenirConcursants("fase", 1);
                    for ($i = 0; $i < count($concursants); $i++) {
                    ?>
                        <form action="process_modificar_concursant.php" method="POST">
                            <input type="hidden" name="nom_amagat" value="<?php echo $concursants[$i]["nom"] ?>">
                            <input type="text" placeholder="Nom" name="nom" value="<?php echo $concursants[$i]["nom"] ?>">
                            <input type="text" placeholder="Imatge" name="imatge" value="<?php echo $concursants[$i]["imatge"] ?>">
                            <input type="text" placeholder="Amo" name="amo" value="<?php echo $concursants[$i]["amo"] ?>">
                            <input type="text" placeholder="Raça" name="raça" value="<?php echo $concursants[$i]["raça"] ?>">
                            <input type="submit" value="Modifica">
                        </form>
                    <?php
                    }
                    ?>

                    <form action="process_afegir_concursant.php" method="POST">
                        <input type="text" name="nom" placeholder="Nom">
                        <input type="text" name="imatge" placeholder="Imatge">
                        <input type="text" name="amo" placeholder="Amo">
                        <input type="text" name="raça" placeholder="Raça">
                        <input type="submit" value="Afegeix">
                    </form>
                </div>

                <div class="admin-row">
                    <h1> Altres operacions: </h1>
                    <form action="process_esborrar_vots.php" method="POST">
                        Esborra els vots de la fase
                        <input type="number" name="nFase" placeholder="Fase" value="">
                        <input type="submit" value="Esborra">
                    </form>
                    <form action="process_esborrar_vots.php" method="POST">
                        Esborra tots els vots
                        <input type="submit" value="Esborra">
                    </form>
                </div>
            </div>
        </div>

    </body>

    </html>
<?php
}
?>