<?php
const TAULA_USERS = 'usuaris';
const TAULA_CONNX = 'connexions';
const SELECT_USER = "select usuari, email, password from usuaris";
const SELECT_CONNX = "select ip, user, time, status from connexions";

/**
 * Llegeix les dades del fitxer. Si el document no existeix torna un array buit.
 *
 * @param string $file
 * @return array
 */
function llegeix(string $select): array
{
    try {
        $hostname = "localhost";
        $dbname = "dwes_victorflores_autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare($select);
    $query->execute();

    $var = [];
    if ($select == SELECT_USER) {
        foreach ($query as $row) {
            $var[$row["email"]] = [ "usuari" => $row["usuari"], "email" => $row["email"], "password" => $row["password"]];
        }
    } else {
        foreach ($query as $row) {
            $var[]= ["ip"=> $row["ip"], "user" => $row["user"], "time"=> $row["time"], "status"=>$row["status"]];
        }
    }


    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $var;
}

/**
 * Guarda les dades a un fitxer
 *
 * @param array $dades
 * @param string $taula
 */
function escriu(array $dades, string $taula): void
{
    if ($taula == "usuaris") {
        insertBD(" values (?, ?, md5(?))", $taula, $dades);
    } else {
        insertBD(" values (?, ?, ?, ?)", $taula, $dades);
    }
}

/**
 * Mostra les connexions d'un usuari amb status success
 *
 * @param string $email
 * @return string
 */
function print_conns(string $email): string
{
    $output = "";
    $data = llegeix(SELECT_CONNX);

    foreach ($data as $vals) {
        if ($vals["user"] == $email && str_contains($vals["status"], "success")){
            $output .= "Connexió des de " . $vals["ip"] . " amb data " . $vals["time"] . "<br>\n";
        }
            
    }

    return $output;
}

/**
 * Inserta les dades a la base de dades
 * 
 * @param string $columnes
 * @param string $taula
 * @param array $dades
 */
function insertBD(string $columnes, string $taula, array $dades)
{
    try {
        $hostname = "localhost";
        $dbname = "dwes_victorflores_autpdo";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $sql = "insert into " . $taula . $columnes;
    $query = $pdo->prepare($sql);
    if ($taula == "usuaris") {
        $query->execute(array($dades["usuari"], $dades["email"], $dades["password"]));
    }else{
        $query->execute($dades);
    }

    $e = $query->errorInfo();
    if ($e[0] != '00000') {
        echo "\nPDO::errorInfo():\n";
        die("Error accedint a dades: " . $e[2]);
    }
}
