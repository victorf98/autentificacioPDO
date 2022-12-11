<?php
require_once "class_admin.php";
require_once "class_concursant.php";
require_once "class_fase.php";
const CONCURSANT = "concursant";
const FASE = "fase";
const ADMIN = "admin";

/**
 * Funció que crea nous concursants/fases/admins depenent de què es passi per paràmetre
 */
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
            $sql = "insert into " . $taula . "(nFase, dataInici, dataFi) values($contingut[0], '$contingut[1]', '$contingut[2]')";
            $query = $pdo->prepare($sql);
            $query->execute();
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

/**
 * Funció que ens actualitza registre(s) a una taula
 */
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

/**
 * Funció que ens ho actualitza tot (o casi tot) a una taula. Creada per fer actualitzacions en massa
 */
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

/**
 * Funció que ens borra un registre a una taula a la base de dades
 */
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

    $sql = "delete from $taula where $columna_unica = $valor_unic";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

/**
 * Funció que ens borra registres en massa a una taula a la base de dades
 */
function deleteTot(string $taula, string $columna_unica, int|string $valor_unic): void
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

    $sql = "delete from $taula where $columna_unica <> $valor_unic";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

/**
 * Funció que ens obté un usuari de la base de dades passant-li el nom i la contrasenya.
 * Si no hi és ens retorna null
 */
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

/**
 * Funció que ens retorna una array amb totes les dades d'una fase en forma d'array
 */
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

/**
 * Funció que ens retorna totes les fases creades a la base de dades
 */
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

/**
 * Funció que ens retorna tots els registres a la taula concursant
 */
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


/**
 * Funció que ens retorna tots els registres de la taula concursants
 * on a la columna que es passi per paràmetre es coincideixi amb el paràmetre "id"
 */
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

/**
 * Funció que ens retorna un registre de la taula fase 
 * on la data que es passi per paràmetre estigui 
 * entre les dates d'alguna fase creada
 */
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
    $query = $pdo->prepare("select * from fase where dataInici <= ? AND dataFi >= ?");
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

/**
 * Funció que en crea els concursants de la fase que s'indiqui per paràmetre
 */
function crearConcursantsNovaFase(array $concursants, int $fase): void
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
        $concursant = new Concursant($concursant_registre["nom"], $concursant_registre["imatge"], $concursant_registre["amo"], $concursant_registre["raça"], $fase);
        //preparem i executem la consulta
        $query = $pdo->prepare("insert into concursant values(?, ?, ?, ?, ?, ?, ?)");
        $query->execute([$concursant->id, $concursant->nom, $concursant->imatge, $concursant->amo, $concursant->raça, $concursant->fase, 0]);
    }

    //eliminem els objectes per alliberar memòria
    unset($pdo);
    unset($query);
}

/**
 * Funció que ordena tots els concursants d'una fase 
 * de menys a més vots i comprova quin d'aquests concursants no passa a la següent fase
 */
function obtenirConcursantsNovaFase(int $fase): array|null
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

    //Obtenim tots els concursants en ordre del que té menys vots al que més
    $query = $pdo->prepare("select * from concursant where fase = ? order by vots ASC");
    $query->execute([$fase]);

    $concursants_nous = [];

    foreach ($query as $row) {
        array_push($concursants_nous, [
            "id" => $row["id"], "nom" => $row["nom"], "imatge" => $row["imatge"],
            "amo" => $row["amo"], "raça" => $row["raça"], "fase" => $row["fase"], "vots" => $row["vots"]
        ]);
    }

    $concursants_a_eliminar = [];
    if ($concursants_nous != null) {
        $vots_minims = $concursants_nous[0]["vots"];
        $llargada_array = count($concursants_nous);
        for ($i = 0; $i < $llargada_array; $i++) {
            if ($concursants_nous[$i]["vots"] == $vots_minims) {
                array_push($concursants_a_eliminar, $concursants_nous[$i]);
                unset($concursants_nous[$i]);
            }
        }
    }

    return comprovarSiNomesHiHaUnPerEliminar($fase, $concursants_nous, $concursants_a_eliminar);
}

/**
 * Fem càlculs i posem els concursants que es salven a una array 
 * i el(s) que està(n) empatat(s) al mínim de vots a una altra array
 */
function calcularConcursantEliminat(int $fase, array $concursants_nous, array $concursants_a_eliminar)
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


    $query = $pdo->prepare("select * from concursant where fase = ? order by vots ASC");
    $query->execute([$fase]);

    $concursants_pendents = [];

    /**
     * Posarem tots els concursants que han empatat a la fase 
     * previament calculada en una array "concursants_pendents"
     * en ordre de menys vots a més
     */
    foreach ($query as $row) {
        for ($j = 0; $j < count($concursants_a_eliminar); $j++) {
            if ($row["nom"] == $concursants_a_eliminar[$j]["nom"]) {
                array_push($concursants_pendents, [
                    "id" => $row["id"], "nom" => $row["nom"], "imatge" => $row["imatge"],
                    "amo" => $row["amo"], "raça" => $row["raça"], "fase" => $row["fase"], "vots" => $row["vots"]
                ]);
            }
        }
    }

    $concursants_per_comprovar = [];

    //Posem el/els concursants que tenen menys vots (empatats a menys vots) a l'array "concursants_per_comprovar"

    if ($concursants_pendents != null) {
        $vots_minims = $concursants_pendents[0]["vots"];
        $llargada_array = count($concursants_pendents);

        for ($i = 0; $i < $llargada_array; $i++) {
            if ($concursants_pendents[$i]["vots"] == $vots_minims) {
                array_push($concursants_per_comprovar, $concursants_pendents[$i]);
                unset($concursants_pendents[$i]);
            }
        }

        //Posem els concursants que no tinguin el mínim de vots a l'array de "concursants_nous"
        foreach ($concursants_pendents as $concursant) {
            array_push($concursants_nous, $concursant);
        }
    }

    return comprovarSiNomesHiHaUnPerEliminar($fase, $concursants_nous, $concursants_per_comprovar);
}

/**
 * Funció que calcula si només hi ha un concursant amb el mínim de vots o estàn empatats. 
 * Si hi ha empat es passarà a mirar els vots de la fase prèvia o es decidirà aleatòriament
 */
function comprovarSiNomesHiHaUnPerEliminar(int $fase, array $concursants_nous, array $concursants_per_comprovar)
{
    /**
     * Si només hi ha un concursant a l'array "concursants_per_comprovar" 
     * retornarem tots els concursants menys els que té menys vots
     */
    if (count($concursants_per_comprovar) == 1) {
        return $concursants_nous;
        //En cas contrari mirarem els vots de la fase anterior
    } else {
        //Si la fase és la 1 i hi ha empat, s'escull un concursant aleatori per eliminar
        if ($fase == 1) {
            unset($concursants_per_comprovar[rand(0, count($concursants_per_comprovar) - 1)]);
            foreach ($concursants_per_comprovar as $concursant) {
                array_push($concursants_nous, $concursant);
            }
            return $concursants_nous;
            //Si no és la fase 1 calcularem els vots de la fase prèvia
        } else {
            return calcularConcursantEliminat($fase - 1, $concursants_nous, $concursants_per_comprovar);
        }
    }
}
