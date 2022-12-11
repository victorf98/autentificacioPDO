<?php
session_start();

require_once "bd_utils.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat votació popular Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper large">
        <header>Resultat de la votació popular del Concurs Internacional de Gossos d'Atura 2023</header>
        <div class="results">
            <?php
            $fases = obtenirFases();
            foreach ($fases as $fase) {
                $concursants = obtenirConcursants("fase", $fase["nFase"]);

                if ($concursants != null) {
            ?>
                    <h1> Resultat fase <?php echo $fase["nFase"] ?></h1>
                    <?php
                }
                foreach ($concursants as $concursant) {
                    //Si el concursant està a la següent fase està en color
                    if (obtenirConcursants("id", $concursant["fase"] + 1 . $concursant["nom"]) != null || obtenirConcursants("fase", $concursant["fase"] + 1) == null) {
                    ?>
                        <img class="dog" alt="<?php echo $concursant["nom"] ?>" title="<?php echo $concursant["nom"] ?>" src="img/<?php echo $concursant["imatge"] ?>">
                    <?php
                    //Si el concursant no està a la següent fase està en blanc i negre
                    } else {
                    ?>
                        <img class="dog eliminat" alt="<?php echo $concursant["nom"] ?>" title="<?php echo $concursant["nom"] ?>" src="img/<?php echo $concursant["imatge"] ?>">
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            <?php
            }
            ?>
        </div>

    </div>

</body>

</html>