<?php
require_once("../models/validator.php");
$validator = new Validator();
setcookie('next_page', 'perfil.php', time()+60);

$password = $perfil['password_aplicante'];
$email = $perfil['email_applicante'];

class concexion{
    public function concexion_local(){
    $dbs = 'mysql:dbname=serenacc; host=localhost';
    $usuario = 'root';
    $contraseña = '';
    try{
    $base = new PDO($dbs, $usuario, $contraseña);
    echo "Conexion exitosa";
    return $base;
    }catch (PDOException $e)  {
        echo 'Fallo la conexion', $e->getMessage();    
    }
    }
}
?>


<?php

echo $contraseña


?>