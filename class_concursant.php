<?php
require_once "bd_utils.php";

class Concursant{
    public string $id;
    public string $nom;
    public string $imatge;
    public string $amo;
    public string $raça;
    public string $fase;
    public int $vots;

    function __construct(string $nom, string $imatge, string $amo, string $raça, string $fase, int $vots = 0)
    {
        $this->id = $fase . $nom;
        $this->nom = $nom;
        $this->imatge = $imatge;
        $this->amo = $amo;
        $this->raça = $raça;
        $this->fase = $fase;
        $this->vots = $vots;
    }

    function insert(){
        insert(CONCURSANT, [$this->id, $this->nom, $this->imatge, $this->amo, $this->raça, $this->fase, $this->vots]);
    }

    function updateConcursant(string|int $id_antiga){
        update(CONCURSANT, "id", $this->id, "id", $id_antiga);
        update(CONCURSANT, "nom", $this->nom, "id", $id_antiga);
        update(CONCURSANT, "imatge", $this->imatge, "id", $id_antiga);
        update(CONCURSANT, "amo", $this->amo, "id", $id_antiga);
        update(CONCURSANT, "raça", $this->raça, "id", $id_antiga);
    }

    function afegirVot(string $id): void{
        update(CONCURSANT, "vots", $this->vots + 1, "id", $id);
    }
}
