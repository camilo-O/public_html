<?php
/*class concexion{
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
}*/

$conn = new mysqli("localhost", "root", "", "serenacc_users_sea_list");

if ($conn->connect_errno)
{
    echo "No hay conexion: (".$conn->connect_errno .")". $conn->connect_error;
}



?>