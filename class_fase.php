<?php
    require_once "bd_utils.php";

    class Fase {
        public int $nFase;
        public string $dataInici;
        public string $dataFi;

        function __construct(int $nFase, string $dataInici, string $dataFi)
        {
            $this->nFase = $nFase;
            $this->dataInici = date("Y-m-d", strtotime($dataInici));
            $this->dataFi =  date("Y-m-d", strtotime($dataFi));
        }

        function insert(){
            insert(FASE, [$this->nFase, $this->dataInici, $this->dataFi]);
        }

        function updateFase():void{
            update(FASE, "dataInici", $this->dataInici, "nFase", $this->nFase);
            update(FASE, "dataFi", $this->dataFi, "nFase", $this->nFase);
        }
    }
?>