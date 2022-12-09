<?php
require_once "class_admin.php";
require_once "class_concursant.php";
require_once "class_fase.php";
const CONCURSANT = "concursant";
const FASE = "fase";
const ADMIN = "admin";

function insert(string $taula, array $contingut): void
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    switch ($taula) {
        case CONCURSANT:
            $sql = "insert into " . $taula . " values(?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute($contingut);
            break;

        case FASE:
            $sql = "insert into " . $taula . " values(?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute($contingut);
            break;

        case ADMIN:
            $sql = "insert into " . $taula . " values(?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute($contingut);
            break;

        default:
            break;
    }

    unset($pdo);
    unset($query);
}

function update(string $taula, string $columna, int|string $valor, string $columna_unica, string|int $valor_unic): void
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $sql = "update $taula set $columna = '$valor' where $columna_unica = '$valor_unic'";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

function updateTot(string $taula, string $columna, int|string $valor, string $columna_unica, string|int $valor_unic): void
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $sql = "update $taula set $columna = '$valor' where $columna_unica <> '$valor_unic'";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

function delete(string $taula, string $columna_unica, int|string $valor_unic): void
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $sql = "delete from ? where ? = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($taula, $columna_unica, $valor_unic));

    unset($pdo);
    unset($query);
}

function obtenirUsuari(string $usuari, string $contrasenya): Admin|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from admin where user = ? AND password = ?");
    $query->execute(array($usuari, md5($contrasenya)));

    $admin = null;
    foreach ($query as $row) {
        $admin = new Admin($row["user"], $row["password"]);
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $admin;
}

function obtenirFase(int $nFase): array|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from fase where nFase = ?");
    $query->execute(array($nFase));

    $fase = [];

    foreach ($query as $row) {
        $fase = ["nFase" => $row["nFase"], "dataInici" => $row["dataInici"], "dataFi" => $row["dataFi"]];
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $fase;
}

function obtenirFases(): array|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from fase");
    $query->execute();

    $fase = [];
    $i = 0;

    foreach ($query as $row) {
        $fase[$i] = ["nFase" => $row["nFase"], "dataInici" => $row["dataInici"], "dataFi" => $row["dataFi"]];
        $i += 1;
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $fase;
}

function obtenirTotsElsConcursants(): array|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from concursant");
    $query->execute();

    $concursants = [];
    $i = 0;

    foreach ($query as $row) {
        $concursants[$i] = ["nom" => $row["nom"], "imatge" => $row["imatge"], "amo" => $row["amo"], "raça" => $row["raça"], "fase" => $row["fase"], "vots" => $row["vots"]];
        $i += 1;
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $concursants;
}

function obtenirConcursants(string $columna, string|int $id): array|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from concursant where $columna = ?");
    $query->execute([$id]);

    $concursant = [];
    $i = 0;

    foreach ($query as $row) {
        $concursant[$i] = ["id" => $row["id"], "nom" => $row["nom"], "imatge" => $row["imatge"], "amo" => $row["amo"], "raça" => $row["raça"], "fase" => $row["fase"], "vots" => $row["vots"]];
        $i += 1;
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $concursant;
}

function trobarFasePerData(string $data): array|null
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    //preparem i executem la consulta
    $query = $pdo->prepare("select * from fase where dataInici < ? AND dataFi > ?");
    $query->execute([$data, $data]);

    $fase = [];

    foreach ($query as $row) {
        $fase = ["nFase" => $row["nFase"], "dataInici" => $row["dataInici"], "dataFi" => $row["dataFi"]];
    }

    //eliminem els objectes per alliberar memòria 
    unset($pdo);
    unset($query);

    return $fase;
}

function crearConcursantsNovaFase(array $concursants): void
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    foreach ($concursants as $concursant_registre) {
        $concursant = new Concursant($concursant_registre["nom"], $concursant_registre["imatge"], $concursant_registre["amo"], $concursant_registre["raça"], $concursant_registre["fase"] + 1);
        //preparem i executem la consulta
        $query = $pdo->prepare("insert into concursants values(?, ?, ?, ?, ?, ?, ?)");
        $query->execute([$concursant->id, $concursant->nom, $concursant->imatge, $concursant->amo, $concursant->raça, $concursant->fase]);
    }

    //eliminem els objectes per alliberar memòria
    unset($pdo);
    unset($query);
}

function obtenirConcursantsNovaFase(int $fase): array
{
    try {
        $hostname = "localhost";
        $dbname = "concurs_gossos_atura";
        $username = "dwes-user";
        $pw = "dwes-pass";
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }

    $query = $pdo->prepare("select * from concursants order by vots ASC where fase = ?");
    $query->execute([$fase]);

    $concursants_nous = [];
    $i = 0;

    foreach ($query as $row) {
        $concursants_nous[$i] = $row;
        $i += 1;
    }

    $concursants_a_eliminar = [];
    $j = 0;

    foreach ($concursants_nous as $concursant) {
        if ($concursant["vots"] == $concursants_nous[0]["vots"]) {
            $concursants_a_eliminar[$j] = $concursant;
            unset($concursant);
            $j += 1;
        }
    }

    if ($j == 1) {
        return $concursants_nous;
    } else {
        return calcularConcursantEliminat();
    }
}

function calcularConcursantEliminat(int $fase, array $concursants_a_eliminar)
{
    if ($fase == 1) {
        unset($concursants_a_eliminar[rand(0, count($concursants_a_eliminar) - 1)]);
        array_push($concursants_nous, $concursants_a_eliminar);
        return $concursants_nous;
    }else{
        return calcularConcursantEliminat($fase - 1, $concursants_a_eliminar);
    }
}
