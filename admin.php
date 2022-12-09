<?php
session_start();
require_once "bd_utils.php";

if (!isset($_SESSION["usuari"])) {
    header("Location: index.php");
} else {
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
                    <h1> Resultat parcial: Fase 1 </h1>
                    <div class="gossos">
                        <?php
                        $concursants = obtenirConcursants("fase", 1);
                            foreach ($concursants as $concursant) {
                        ?>
                                <img class="dog" alt="<?php echo $concursant["nom"] ?>" title="<?php echo $concursant["nom"] . " " . $concursant["vots"]?>" src="img/<?php echo $concursant["imatge"] ?>">
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
                        del <input type="date" name="dataInici" value="<?php if(obtenirFase(1) != null) echo obtenirFase(1)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(1) != null) echo obtenirFase(1)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="2" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(2) != null)echo obtenirFase(2)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(2) != null)echo obtenirFase(2)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="3" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(3) != null)echo obtenirFase(3)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(3) != null)echo obtenirFase(3)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="4" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(4) != null)echo obtenirFase(4)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(4) != null)echo obtenirFase(4)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="5" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(5) != null)echo obtenirFase(5)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(5) != null)echo obtenirFase(5)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="6" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(6) != null)echo obtenirFase(6)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(6) != null)echo obtenirFase(6)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="7" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(7) != null)echo obtenirFase(7)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(7) != null)echo obtenirFase(7)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="fase-row" action="process_fase.php" method="POST">
                        Fase <input type="number" name="nFase" value="8" style="width: 3em">
                        del <input type="date" name="dataInici"  value="<?php if(obtenirFase(8) != null)echo obtenirFase(8)["dataInici"]?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if(obtenirFase(8) != null)echo obtenirFase(8)["dataFi"]?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                </div>

                <div class="admin-row">
                    <h1> Concursants: </h1>

                    <?php 
                    $concursants = obtenirTotsElsConcursants();
                        for ($i=0; $i < count($concursants); $i++) { 
                    ?>
                    <form action="process_modificar_concursant.php" method="POST">
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