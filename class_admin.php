<?php
require_once "bd_utils.php";

class Admin {
    public string $user;
    public string $password;

    function __construct(string $user, string $password){
        $this->user = $user;
        $this->password = $password;
    }

    //Crear nou usuari admin
    function insert(){
        insert(ADMIN, [$this->user, md5($this->password)]);
    }
}
?>